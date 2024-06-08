<?php

namespace App\ShoppingCart;

use App\ShoppingCart\Exceptions\ItemDoesNotExistsInShoppingCart;
use App\ShoppingCart\Exceptions\ItemExistsInShoppingCart;
use Exception;

/**
 * Class CartAdaptor
 *
 * Provides a static interface for managing the shopping cart.
 *
 * @package App\ShoppingCart
 */
class CartAdaptor
{
    /**
     * @var Cart|null $cartInstance Singleton instance of the Cart
     */
    private static ?Cart $cartInstance = null;

    /**
     * @var self|null $instance Singleton instance of CartAdaptor
     */
    private static ?self $instance = null;

    /**
     * Initialize the CartAdaptor with the user ID and installment option.
     *
     * @param int $userId ID of the user
     * @param bool $is_installment Indicates if the cart uses installment payment
     * @return self The instance of CartAdaptor
     */
    public static function init(int $userId, bool $is_installment = false): self
    {
        if (empty(static::$instance) || empty(static::$cartInstance)) {
            static::$cartInstance = resolve(Cart::class, [
                'userId' => $userId,
                'installment' => $is_installment
            ]);
            static::$instance = new self;
        }

        return static::$instance;
    }

    /**
     * Add a course to the cart by its ID.
     *
     * @param int $productId ID of the product to add
     * @throws ItemExistsInShoppingCart If the product already exists in the cart
     * @return void
     */
    public static function addCourse(int $productId): void
    {
        static::$cartInstance->add(
            resolve(CourseItem::class, ['product_id' => $productId])
        );
    }
    /**
     * Add a package to the cart by its ID.
     *
     * @param int $productId ID of the product to add
     * @throws ItemExistsInShoppingCart If the product already exists in the cart
     * @return void
     */
    public static function addPackage(int $productId): void
    {
        static::$cartInstance->add(
            resolve(PackageItem::class, ['product_id' => $productId])
        );
    }

    /**
     * Update a product in the cart by its ID.
     *
     * @param int $productId ID of the product to update
     * @throws ItemDoesNotExistsInShoppingCart If the product does not exist in the cart
     * @return void
     */
    public static function updateCourse(int $productId): void
    {
        static::$cartInstance->update(
            resolve(CourseItem::class, ['product_id' => $productId])
        );
    }

    /**
     * Update a product in the cart by its ID.
     *
     * @param int $productId ID of the product to update
     * @throws ItemDoesNotExistsInShoppingCart If the product does not exist in the cart
     * @return void
     */
    public static function updatePackage(int $productId): void
    {
        static::$cartInstance->update(
            resolve(PackageItem::class, ['product_id' => $productId])
        );
    }

    /**
     * Remove a product from the cart by its ID.
     *
     * @param int $productId ID of the product to remove
     * @throws ItemDoesNotExistsInShoppingCart If the product does not exist in the cart
     * @return void
     */
    public static function remove(int $productId): void
    {
        static::$cartInstance->remove($productId);
    }

    /**
     * Magic method to call methods on the Cart instance dynamically.
     *
     * @param string $method Name of the method to call
     * @param array $parameters Parameters to pass to the method
     * @throws Exception If the method does not exist on the Cart instance
     * @return mixed The result of the method call
     */
    public static function __callStatic(string $method, array $parameters)
    {
        if (! method_exists(static::$cartInstance, $method)) {
            throw new Exception('The ' . $method . ' method is not supported.');
        }

        return call_user_func_array([static::$cartInstance, $method], $parameters);
    }
}
