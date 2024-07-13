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
        $discountCode = null;
        return [
            'items' => $this->collection->map(function($item) use(&$discountCode){
               return  [
                    'product_id' => $item->product_id,
                    'product_name' => $item->getModel()->product->name,
                    'product_image' => $item->getModel()->product->getImageUrl(),
                    'has_installment' => $item->getModel()->product->has_installment,
                    'options' => $item->getModel()->product->options,
                    "original_price" => $item->getModel()->product->getPrice(),
                    "off_price" => $item->getModel()->product->off_price,
                    'discount_code' => $this->when(!!$item->couponCode, $discountCode = $item->couponCode),
                    'product_calculated_price' => $item->getCalcPrice(),
                    'is_package' => $item instanceof PackageItem,
                    'package_items' => $this->when($item instanceof PackageItem, fn() => $item->getModel()->packages->map(fn($item) => [
                        'id' => $item->id,
                        'product_id' => $item->product->id,
                        'name' => $item->product->name,
                    ]))
                ];
                })->toArray(),
            'invoice' => [
                'discount_code' => $this->when(!empty($discountCode), $discountCode),
                "vat" => CartAdaptor::getTotalTax(),
                "vat_percentage" => config('shoppingcart.vat') * 100,
                "user_credit" => $this->userCredit,
                "sum_price" => CartAdaptor::getTotal(),
                "final_price" => (int)(CartAdaptor::getTotal() * (config('shoppingcart.vat')+1)),
                "payable_price" => CartAdaptor::getPayableAmount(),
                "payable_for_bank" => (CartAdaptor::getPayableAmount() - $this->userCredit) > 0 ? CartAdaptor::getPayableAmount() - $this->userCredit : 0 // sub-track with user balance
            ],
            'installments' => $this->when(CartAdaptor::isInstallment(), CartAdaptor::getInstallments())
        ];
    }
}
