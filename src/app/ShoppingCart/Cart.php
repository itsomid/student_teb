<?php

namespace App\ShoppingCart;

use App\ShoppingCart\Contract\CartItemInterface;
use App\ShoppingCart\Events\CartAdded;
use App\ShoppingCart\Events\CartDeleted;
use App\ShoppingCart\Events\CartUpdated;
use App\ShoppingCart\Exceptions\CouponNotUsableException;
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

        if (count($items = $this->cartItemRepository->findByUserId($userId))){
            $this->isInstallment = $items[0]->is_installment;
        }
        $this->items =  new Collection($items);
    }

    /**
     * Add an item to the cart.
     *
     * @param CourseItem $item Item to be added
     * @return void
     *@throws ItemExistsInShoppingCart If the item already exists in the cart
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
     *@throws ItemDoesNotExistsInShoppingCart If the item does not exist in the cart
     */
    public function update(CartItemInterface $item): void
    {
        if (! $this->isItemExists($item->product_id)) {
            throw new ItemDoesNotExistsInShoppingCart("Item does not exists in shopping cart in update action");
        }
        $this->items = $this->items->map(fn ($row) => $row->product_id === $item->product_id ? $item : $row);
        event(CartUpdated::class, $item);
    }

    /**
     * Remove an item from the cart.
     *
     * @param int $id ID of the item to be removed
     * @throws ItemDoesNotExistsInShoppingCart If the item does not exist in the cart
     * @return void
     */
    public function remove(int $id): void
    {
        if (! $this->isItemExists($id)) {
            throw new ItemDoesNotExistsInShoppingCart("Item does not exists in shopping cart in remove action");
        }

        $item = $this->items->where('product_id', $id)->first();
        $item->remove();
        $this->items = $this->items->reject(fn ($row) => $row->product_id === $id);

        event(CartDeleted::class, $item);
    }

    /**
     * Get a specific item from the cart.
     *
     * @param int $id ID of the item to retrieve
     * @return CourseItem The retrieved item
     *@throws ItemDoesNotExistsInShoppingCart If the item does not exist in the cart
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
        return !! $this->items->where('product_id', $id)->count();
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
     * @param bool $is_installment Whether to use installment payment
     * @throws ItemNotInstallmentableException If an item cannot be purchased on installment
     * @return void
     */
    public function changeInstallment(bool $is_installment = true): void
    {
        if (! is_null($hasntInstallment = $this->items->where('hasInstallmentMethod', false)->first())) {
            throw new ItemNotInstallmentableException('This product cannot be purchased on installment: ' . $hasntInstallment->product_id);
        }
        foreach ($this->items as $item) {
            $item->initInstallment();
        }
        $this->cartItemRepository->updateInstallmentByUserId($this->userId, $is_installment);
        $this->isInstallment = $is_installment;
    }

    /**
     * Apply a coupon to all items in the cart.
     *
     * @param string $couponCode ID of the coupon to apply
     * @return void
     */
    public function applyCoupon(string $couponCode): void
    {
        $this->items = $this->items->map(function (CartItemInterface $item) use($couponCode){
            if ($this->couponValidator->isCouponValid($couponCode, $item->getModel()->product->id, $this->user->id)) {
                return tap($item)->changeCouponCode($couponCode)->update();
            }else{
                throw new CouponNotUsableException;
            }
        });
    }

    /**
     * Get the total payable amount.
     *
     * @return int The total amount payable, including discounts, VAT, and installment adjustments
     */
    public function getPayableAmount(): int
    {
        $sum = $this->items->reduce(fn (?int $carry, CartItemInterface $item) =>
        ($carry + $item->getCalcPrice())
            , 0);

        return (int) $sum;
    }

    /**
     * Get the total tax for the cart.
     *
     * @return int The total tax amount
     */
    public function getTotalTax(): int
    {
        $sum = $this->items->reduce(fn (?int $carry, CartItemInterface $item) =>
        ($carry + $item->getTax())
            , 0);

        return (int) $sum;
    }

    /**
     * Get the total amount before discounts.
     *
     * @return int The total amount before applying discounts
     */
    public function getTotal(): int
    {
        $sum = $this->items->reduce(fn (?int $carry, CartItemInterface $item) =>
        ($carry + $item->getPriceWithDiscount())
            , 0);

        return (int) $sum;
    }

    /**
     * Get the array of installments.
     *
     * @return array An array of installments with dates and amounts
     */
    public function getInstallments(): array
    {
        $installments = [];

        if (! $this->isInstallment) {
            return [];
        }

        foreach($this->items as $item)
        {
            if (count($generatedInstallment = $item->installment->generateInstallments()))
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
}
