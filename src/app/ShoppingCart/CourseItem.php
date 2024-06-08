<?php

namespace App\ShoppingCart;

use App\Enums\ProductTypeEnum;
use App\Models\CartItem as CartItemModel;
use App\Models\Product;
use App\ShoppingCart\Contract\CartItemInterface;
use App\ShoppingCart\Exceptions\ProductDoesNotExistsException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class CourseItem
 *
 * Represents a course item in the shopping cart.
 * Implements the CartItemInterface to manage course-related cart operations.
 *
 * @package App\ShoppingCart
 */
class CourseItem implements CartItemInterface
{
    /**
     * The Eloquent model representing the cart item.
     *
     * @var Model
     */
    private Model $model;

    /**
     * The installment plan associated with the cart item.
     *
     * @var Installment|null
     */
    public ?Installment $installment = null;

    /**
     * CourseItem constructor.
     *
     * @param int $product_id The ID of the product.
     * @param int|null $coupon_id The ID of the coupon applied to the item (optional).
     * @param int $user_id The ID of the user (default is 0).
     * @param bool $is_installment Whether the item is purchased on installment (default is false).
     * @throws ProductDoesNotExistsException If the product does not exist in the database.
     */
    public function __construct(
        public int $product_id,
        public ?int $coupon_id = null,
        public int $user_id = 0,
        public bool $is_installment = false,
    ) {
        if (!Product::query()->where('id', $this->product_id)->exists()) {
            throw new ProductDoesNotExistsException("Product Does Not Exist, product_id: {$this->product_id}");
        }
    }

    /**
     * Save the course item to the database.
     *
     * @return void
     */
    public function save(): void
    {
        $this->addModel(CartItemModel::query()->create([
            'product_id' => $this->product_id,
            'coupon_id' => $this->coupon_id,
            'user_id' => $this->user_id,
            'is_installment' => $this->is_installment,
            'product_type_id' => ProductTypeEnum::COURSE
        ]));
    }

    /**
     * Get the Eloquent model representing the cart item.
     *
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Set the Eloquent model for the cart item and initialize installment if applicable.
     *
     * @param Model $model The Eloquent model to set.
     * @return void
     */
    public function addModel(Model $model): void
    {
        $this->model = $model;
        $this->initInstallment();
    }

    /**
     * Update the course item in the database.
     *
     * @return self
     */
    public function update(): self
    {
        $this->model->save();
        return $this;
    }

    /**
     * Remove the course item from the database.
     *
     * @return void
     */
    public function remove(): void
    {
        $this->model->delete();
    }

    /**
     * Change a property of the course item.
     *
     * This method dynamically updates properties based on the method name.
     *
     * @param string $name The name of the method called.
     * @param mixed $value The value to set.
     * @return self
     */
    public function change(string $name, $value)
    {
        $name = Str::snake(lcfirst(str_replace('change', '', $name)));
        $this->{$name} = $value;
        $this->model->{$name} = $value;

        return $this;
    }

    /**
     * Handle dynamic method calls for changing properties.
     *
     * @param string $methodName The name of the method called.
     * @param array $args The arguments passed to the method.
     * @return mixed
     */
    public function __call(string $methodName, array $args)
    {
        if (Str::startsWith($methodName, 'change')) {
            return $this->change($methodName, $args[0]);
        }
    }

    /**
     * Get the calculated price for the course item.
     *
     * If the item is purchased on installment, return the payable installment price.
     *
     * @return int
     */
    public function getCalcPrice(): int
    {
        if ($this->is_installment) {
            return $this->installment->getPayablePrice();
        }
        return $this->getPrice();
    }

    /**
     * Get the total price of the course item, including VAT.
     *
     * @return int
     */
    public function getPrice(): int
    {
        $final_price = $this->getPriceWithDiscount();
        return ($final_price * ($this->getVatPercentage() + 1));
    }

    /**
     * Get the tax amount for the course item.
     *
     * @return float|int
     */
    public function getTax(): float|int
    {
        return $this->getPriceWithDiscount() * $this->getVatPercentage();
    }

    /**
     * Get the price of the course item after applying discounts.
     *
     * @return int
     */
    public function getPriceWithDiscount(): int
    {
        $final_price = $this->model->product->off_price ?? $this->getOriginalPrice();

        if ($this->model->coupon && $this->model->coupon->discount_price) {
            $final_price -= $this->model->coupon->discount_price;
        } elseif ($this->model->coupon && $this->model->coupon->discount_percentage) {
            $final_price -= ($final_price * ($this->model->coupon->discount_percentage / 100));
        }
        return $final_price;
    }

    /**
     * Get the original price of the course item.
     *
     * @return int
     */
    public function getOriginalPrice(): int
    {
        return $this->model->product->original_price;
    }

    /**
     * Initialize the installment plan for the course item if applicable.
     *
     * @return void
     */
    private function initInstallment(): void
    {
        if ($this->is_installment) {
            $this->installment = resolve(Installment::class, ['cartItem' => $this]);
        }
    }

    /**
     * Get the VAT percentage applicable to the course item.
     *
     * @return float
     */
    public function getVatPercentage(): float
    {
        return config('shoppingcart.vat');
    }
}
