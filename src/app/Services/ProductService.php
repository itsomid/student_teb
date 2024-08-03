<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    private const string PRODUCT_TREE_CACHE_KEY = 'product_tree';
    private const int CACHE_EXPIRATION_MINUTES = 120;
    private array $cachedProductTreeLeaves = [];

    /**
     * Clears the product tree cache when a product is changed.
     * @return void
     */
    public static function clearProductTreeCache(): void
    {
        Cache::forget(self::PRODUCT_TREE_CACHE_KEY);
    }

    /**
     * Retrieves the product tree, either from cache or by generating it.
     * @return array
     */
    private function getProductTree(): array
    {
        return Cache::remember(self::PRODUCT_TREE_CACHE_KEY, self::CACHE_EXPIRATION_MINUTES, function () {
            $products = Product::query()->orderBy('parent_id')->get();
            $tree = [];

            foreach ($products as $product) {
                if (!$product->parent_id) {
                    $tree[$product->id] = [];
                } else {
                    $tree = $this->addProductToTree($tree, $product->id, $product->parent_id);
                }
            }
            return $tree;
        });
    }

    /**
     * Adds a product to the tree using a BFS search to find the correct parent node.
     * @param array $tree
     * @param int $productId
     * @param int $parentId
     * @return array
     */
    private function addProductToTree(array $tree, int $productId, int $parentId): array
    {
        foreach ($tree as $currentParentId => $children) {
            if ($currentParentId == $parentId) {
                $tree[$currentParentId][$productId] = [];
                return $tree;
            }
        }

        foreach ($tree as $currentParentId => $children) {
            if (count($children) > 0) {
                $tree[$currentParentId] = $this->addProductToTree($children, $productId, $parentId);
            }
        }

        return $tree;
    }

    /**
     * Retrieves the leaf nodes of the product tree.
     * @param array $userProductIds
     * @return array
     */
    public function getProductTreeLeaves(array $userProductIds): array
    {
        if (count($this->cachedProductTreeLeaves)){
            return $this->cachedProductTreeLeaves;
        }
        $productTree = $this->getProductTree();
        return $this->cachedProductTreeLeaves = $this->findProductTreeLeaves($userProductIds, $productTree);
    }

    /**
     * Helper method to recursively find the leaf nodes of the product tree.
     * @param array $userProductIds
     * @param array $productTree
     * @param bool $includeAll
     * @return array
     */
    private function findProductTreeLeaves(array $userProductIds, array $productTree, bool $includeAll = false): array
    {
        $leaves = [];
        foreach ($productTree as $productId => $children) {
            if ($includeAll || in_array($productId, $userProductIds)) {
                $leaves[] = $productId;
                $leaves = array_merge($leaves, $this->findProductTreeLeaves($userProductIds, $children, true));
            } else {
                $leaves = array_merge($leaves, $this->findProductTreeLeaves($userProductIds, $children, false));
            }
        }
        return $leaves;
    }
}
