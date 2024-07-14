<?php

namespace App\Http\Resources\StudentPanel\Cart;

use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\PackageItem;
use Carbon\Carbon;
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
                    "original_price" => $item->getModel()->product->price,
                    "off_price" => $item->getModel()->product->off_price,
                    'discount_code' => $this->when(!!$item->couponCode, $discountCode = $item->couponCode),
                    'product_calculated_price' => $item->getPrice(),
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
                "final_price" => CartAdaptor::getFinalPrice(),
                "payable_price" => CartAdaptor::getPayableAmount(),
                "payable_for_bank" => (CartAdaptor::getPayableAmount() - $this->userCredit) > 0 ? CartAdaptor::getPayableAmount() - $this->userCredit : 0 // sub-track with user balance
            ],
            'installments' => $this->when(CartAdaptor::isInstallment(), $this->mergeAmountsByDate(CartAdaptor::getInstallments()))
        ];
    }

    function mergeAmountsByDate(array $data): array
    {
        $merged = [];

        foreach ($data as $key => $entries) {
            foreach ($entries as $entry) {
                $date = Carbon::parse($entry['date'])->toDateString(); // Normalize date to "Y-m-d"
                if (isset($merged[$date])) {
                    $merged[$date]['amount'] += $entry['amount'];
                } else {
                    $merged[$date] = [
                        'date' => $date,
                        'amount' => $entry['amount']
                    ];
                }
            }
        }

        // Convert the merged associative array back to a flat indexed array
        return array_values($merged);
    }
}
