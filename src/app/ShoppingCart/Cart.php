<?php

namespace App\ShoppingCart;

use App\ShoppingCart\Contract\CartItemInterface;
use App\ShoppingCart\Events\CartAdded;
use App\ShoppingCart\Events\CartDeleted;
use App\ShoppingCart\Events\CartUpdated;
use App\ShoppingCart\Exceptions\CouponNotUsableProductNotApplicable;
use App\ShoppingCart\Exceptions\ItemDoesNotExistsInShoppingCart;
use App\ShoppingCart\Exceptions\ItemExistsInShoppingCart;
use App\Models\User;
use App\ShoppingCart\Exceptions\ItemNotInstallmentableException;
use Illuminate\Support\Collection;

/**
 * Class Cart
 *
 * @package App\ShoppingCart
 */
class Cart
{
    /**
     * @var Collection $items Collection of CartItem objects
     */
    private Collection $items;

    /**
     * @var int|null $userId ID of the user associated with the cart
     */
    private ?int $userId;

    /**
     * @var User|null $user User object associated with the cart
     */
    private ?User $user;

    /**
     * @var bool $isInstallment Indicates if the cart uses installment payment
     */
    private bool $isInstallment;

    /**
     * @var CartItemRepository $cartItemRepository Repository for managing cart items
     */
    private CartItemRepository $cartItemRepository;

    /**
     * @var CouponValidator $couponValidator Validator for coupons
     */
    private CouponValidator $couponValidator;

    /**
     * Cart constructor.
     *
     * @param int $userId ID of the user
     * @param bool $installment Indicates if the cart uses installment payment
     * @param CartItemRepository $cartItemRepository Repository for managing cart items
     * @param CouponValidator $couponValidator Validator for coupons
     */
    public function __construct(int $userId, bool $installment, CartItemRepository $cartItemRepository, CouponValidator $couponValidator)
    {
        $this->isInstallment = $installment;
        $this->userId = $userId;
        $this->user = User::query()->find($userId);
        $this->cartItemRepository = $cartItemRepository;
        $this->couponValidator = $couponValidator;

        if (count($items = $this->cartItemRepository->findByUserId($userId))) {
            $this->isInstallment = $items->first()->is_installment;
        }
        $this->items = new Collection($items);
    }

    /**
     * Add an item to the cart.
     *
     * @param CourseItem $item Item to be added
     * @return void
     * @throws ItemExistsInShoppingCart If the item already exists in the cart
     */
    public function add(CartItemInterface $item): void
    {
        if ($this->isItemExists($item->product_id)) {
            throw new ItemExistsInShoppingCart("Item already added to shopping cart, id: {$item->product_id}");
        }
        $item->user_id = $this->userId;
        $item->is_installment = $this->isInstallment;
        $this->items->add($item);
        $item->save();

        event(CartAdded::class, $item);
    }

    /**
     * Update an item in the cart.
     *
     * @param CourseItem $item Item to be updated
     * @return void
     * @throws ItemDoesNotExistsInShoppingCart If the item does not exist in the cart
     */
    public function update(CartItemInterface $item): void
    {
        if (!$this->isItemExists($item->product_id)) {
            throw new ItemDoesNotExistsInShoppingCart("Item does not exists in shopping cart in update action");
        }
        $this->items = $this->items->map(fn($row) => $row->product_id === $item->product_id ? $item : $row);
        event(CartUpdated::class, $item);
    }

    /**
     * Remove an item from the cart.
     *
     * @param int $id ID of the item to be removed
     * @return void
     * @throws ItemDoesNotExistsInShoppingCart If the item does not exist in the cart
     */
    public function remove(int $id): void
    {
        if (!$this->isItemExists($id)) {
            throw new ItemDoesNotExistsInShoppingCart("Item does not exists in shopping cart in remove action");
        }

        $item = $this->items->where('product_id', $id)->first();
        $item->remove();
        $this->items = $this->items->reject(fn($row) => $row->product_id === $id);

        event(CartDeleted::class, $item);
    }

    /**
     * Get a specific item from the cart.
     *
     * @param int $id ID of the item to retrieve
     * @return CourseItem The retrieved item
     * @throws ItemDoesNotExistsInShoppingCart If the item does not exist in the cart
     */
    public function getItem(int $id): CourseItem
    {
        $item = $this->items->where('product_id', $id)->first();
        if (is_null($item)) {
            throw new ItemDoesNotExistsInShoppingCart("Cart Item Does Not Exists . id: {$id}");
        }

        return $item;
    }

    /**
     * Get all items in the cart.
     *
     * @return Collection Collection of CartItem objects
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * Check if an item exists in the cart.
     *
     * @param int $id ID of the item to check
     * @return bool True if the item exists, false otherwise
     */
    public function isItemExists(int $id): bool
    {
        return !!$this->items->where('product_id', $id)->count();
    }

    /**
     * Set the user for the cart.
     *
     * @param int $id ID of the user
     * @return self
     */
    public function forUser(int $id): self
    {
        $this->userId = $id;
        return $this;
    }

    /**
     * Change the installment payment method.
     *
     * @return void
     */
    public function removeInstallment(): void
    {
        if (!is_null($this->items->where('hasInstallmentMethod', false)->first())) {
//            \Log::info('try to remove installment');
            $this->cartItemRepository->updateInstallmentByUserId($this->userId, false);
            $this->isInstallment = false;
        }

    }
    public function changeInstallment(bool $is_installment): bool
    {
        if (!is_null($hasntInstallment = $this->items->where('hasInstallmentMethod', false)->first())) {
            throw new ItemNotInstallmentableException('This product cannot be purchased on installment: ' . $hasntInstallment->product_id);
        }
        foreach ($this->items as $item) {
//            \Log::info('changeInstallment method');
            $item->initInstallment();
        }
        $this->cartItemRepository->updateInstallmentByUserId($this->userId, $is_installment);
        $this->isInstallment = $is_installment;
        return $this->isInstallment;
    }
    public function getAppliedCouponName()
    {

        $itemWithCoupon = $this->items->first(function (CartItemInterface $item) {
            return $item->getCouponName() !== null;
        });

        return $itemWithCoupon ? $itemWithCoupon->getCoupon()->coupon_name : null;
    }

    public function getAppliedCouponAmount(): int
    {
        return $this->items->sum(fn($item) => $item->getCouponDiscountAmount());
    }

    /**
     * Apply a coupon to all items in the cart.
     *
     * @param int $coupon_id ID of the coupon to apply
     * @return void
     * @throws CouponNotUsableProductNotApplicable
     */

    public function applyCoupon(int $coupon_id): void
    {

        $nonEligibleProducts = [];
        $isEligible = false;

        // Validate each product and check if at least one is satisfied
        $this->items->each(function (CartItemInterface $item) use ($coupon_id, &$nonEligibleProducts, &$isEligible) {
            if ($this->couponValidator->isCouponValid($coupon_id, $item->getModel()->product->id, $this->user->id)) {
                $isEligible = true;
            } else {
                $nonEligibleProducts[] = $item->getModel()->product->id;
            }
        });

        // If all products(cart items) are not satisfy, throw an exception
        if (!$isEligible) {
            throw new CouponNotUsableProductNotApplicable;
        }

        // Apply the coupon only to satisfy items
        $this->items = $this->items->map(function (CartItemInterface $item) use ($coupon_id, $nonEligibleProducts) {
            if (!in_array($item->getModel()->product->id, $nonEligibleProducts)) {
                return tap($item)->changeCouponName($coupon_id)->update();
            }
            return $item;
        });

    }

    public function removeCoupon(int $coupon_id): void
    {
        $this->items = $this->items->map(function (CartItemInterface $item) use ($coupon_id) {
            return tap($item)->changeCouponName(null)->update();
        });
    }

    /**
     * Get the Final Price With Vat and discount.
     *
     * @return int The total amount after applying discount
     */
    public function getFinalPrice(): int
    {
        return $this->getTotal() + $this->getTotalTax();
    }
    /**
     * Get the total amount with discounts.(Without Vat)
     *
     * @return int The total amount After Applying Discount
     */
    public function getTotal(): int
    {
        return $this->items->sum(fn(CartItemInterface $item) => $item->getPriceWithDiscount());
    }
    /**
     * Get the total payable amount.
     *
     * @return int The total amount payable, including discounts, VAT, and installment adjustments
     */
    public function getPayableAmount(): int
    {
        return $this->items->sum(fn(CartItemInterface $item) => $item->getCalcPrice());
    }
    /**
     * Get the total tax for the cart.
     *
     * @return int The total tax amount
     */
    public function getTotalTax(): int
    {
        return $this->items->sum(fn(CartItemInterface $item) => $item->getTax());
    }

    /**
     * @return int
     */
    public function getInstallmentCount(): int
    {
        $installmentCount = 0;
        foreach ($this->getInstallments() as $productInstallments){
            $installmentCount += count($productInstallments);
        }
        return $installmentCount;
    }
    /**
     * Get the array of installments.
     *
     * @return array An array of installments with dates and amounts
     */

    public function getInstallments(): array
    {

        $installments = [];

        if (!$this->isInstallment) {
            return [];
        }

        foreach ($this->items as $item) {
            $generatedInstallment = $item->installment->generateInstallments();

            if (count($generatedInstallment))
                $installments[$item->product_id] = $generatedInstallment;
        }

        return $installments;
    }

    /**
     * @return bool
     */
    public function isInstallment(): bool
    {
        return $this->isInstallment;
    }

    public function hasCoupon(): bool
    {
        return $this->items->contains(fn($item) => $item->getCouponName() !== null);
    }

}
