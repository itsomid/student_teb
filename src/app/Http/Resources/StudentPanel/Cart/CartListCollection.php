<?php

namespace App\Http\Resources\StudentPanel\Cart;

use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\PackageItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartListCollection extends ResourceCollection
{

    public function __construct($resource, private readonly int $userCredit)
    {
        parent::__construct($resource);

    }

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
                'product_name' => $item->getModel()->product->name,
                'product_image' => $item->getModel()->product->getImageUrl(),
                'has_installment' => $item->getModel()->product->has_installment,
                'options' => $item->getModel()->product->options,
                'product_price' => $item->getModel()->product->original_price,
                'product_calculated_price' => $item->getCalcPrice(),
                'is_package' => $item instanceof PackageItem,
                'package_items' => $item->getModel()->packages->map(fn($item)=>[
                    'id' => $item->id,
                    'product_id' => $item->product->id,
                    'name' => $item->product->name,
                ])
            ])->toArray(),
            'invoice' => [
                "vat" => CartAdaptor::getTotalTax(),
                "vat_percentage" => config('shoppingcart.vat') * 100,
                "gift_credit_usage" => 'NOT IMPLEMENT',
                "gift_amount" => 'NOT IMPLEMENT',
                "sum_price" => CartAdaptor::getTotal(),
                "final_price" => CartAdaptor::getTotal() * (config('shoppingcart.vat')+1),
                "payable_price" => CartAdaptor::getPayableAmount(),
                "payable_for_bank" => (CartAdaptor::getPayableAmount() - $this->userCredit) > 0 ? CartAdaptor::getPayableAmount() - $this->userCredit : 0 // sub-track with user balance
            ]

        ];
    }
}
