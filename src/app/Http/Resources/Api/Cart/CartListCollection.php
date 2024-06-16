<?php

namespace App\Http\Resources\Api\Cart;

use App\ShoppingCart\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartListCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'items' => $this->collection->map(fn($item) =>   [
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->getImageUrl(),
                'has_installment' => $item->product->has_installment,
                'options' => $item->product->options,
                'product_price' => $item->product->original_price,
                'product_calculated_price' => $item->getCalcPrice(),
                'is_package' => $item instanceof PackageItem,
                'package_items' => ''
            ]),
            'invoice' => [
                "conditions" => '',
                "vat"        => '',
                "vat_percentage" => '',
                "gift_credit_usage" => '',
                "gift_amount" => '',
                "sum_price" => '',
                "final_price" => '',
                "payable_price" => '',
                "payable_for_bank" => ''
            ]

        ];
    }
}
