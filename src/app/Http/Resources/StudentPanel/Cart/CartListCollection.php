<?php

namespace App\Http\Resources\StudentPanel\Cart;

use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\Contract\CartItemInterface;
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
        return [
            'items' => $this->collection->map(fn(CartItemInterface $item) =>   [
                'product_id' => $item->product_id,
                'product_name' => $item->getModel()->product->name,
                'product_image' => $item->getModel()->product->getImageUrl(),
                'has_installment' => $item->getModel()->product->has_installment,
                'options' => $item->getModel()->product->options,
                "original_price" => $item->getModel()->product->getPrice(),
                "original_price_num" => $item->getModel()->product->original_price,
                "off_price" => $item->getModel()->product->getOffPrice(),
                "off_price_num" => $item->getModel()->product->off_price,
                'discount_code' => $this->when(CartAdaptor::hasCoupon(), optional($item->getModel()->coupon)->coupon_name),
                'discount_amount' => $this->when(CartAdaptor::hasCoupon(),$item->getCouponDiscountAmount()),
                'product_calculated_price' => $item->getCalcPrice(),
                'product_calculated_price_without_vat' => $item->getPriceWithDiscount(),
                'is_package' => $item instanceof PackageItem,
                'package_items' => $this->when($item instanceof PackageItem, fn ()=>
                    $item->getModel()->packages->map(fn($item)=>[
                        'id' => $item->id,
                        'product_id' => $item->product->id,
                        'name' => $item->product->name,
                    ]))
            ])->toArray(),
            'invoice' => [
                'discount_code' =>  $this->when(CartAdaptor::hasCoupon(),CartAdaptor::getAppliedCouponName()),
                "discount_amount" =>$this->when(CartAdaptor::hasCoupon(),CartAdaptor::getAppliedCouponAmount()),
                "vat" => CartAdaptor::getTotalTax(),
                "vat_percentage" => config('shoppingcart.vat') * 100,
//                "installment_percentage"=>$this->when(CartAdaptor::isInstallment(),config('shoppingcart.vat') * 100),
//                "installment_amount"=>$this->when(CartAdaptor::isInstallment(),config('shoppingcart.vat') * 100),
                "user_credit" => $this->userCredit,
                "sum_price" => CartAdaptor::getTotal(), //Without vat
                "final_price" => CartAdaptor::getFinalPrice(),//with vat
                "payable_price" => CartAdaptor::getPayableAmount(),//with vat,discount,installment
                "payable_for_bank" => (CartAdaptor::getPayableAmount() - $this->userCredit) > 0 ? intval(CartAdaptor::getPayableAmount() - $this->userCredit) : 0 // sub-track with user balance
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
