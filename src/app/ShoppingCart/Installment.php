<?php

namespace App\ShoppingCart;

use App\ShoppingCart\Contract\CartItemInterface;
use Carbon\Carbon;


class Installment
{
    private array $installment_array = [];


    public function __construct(private readonly CartItemInterface $cartItem)
    {
    }

    public function getPayablePrice(): int
    {
        return $this->generateInstallments()[0]['amount'];
    }

    public function getInstallments(): array
    {
        return $this->generateInstallments();
    }


    public function generateInstallments(): array
    {

        if (count($this->installment_array)) {
            return $this->installment_array;
        }
        $product = $this->cartItem->getModel()->product;
        if (!$product->has_installment) {
            return [];
        }

        //config generation of Installments
        $installment_count          = $product->installment_count ?: 4; //include first installment
        $first_installment_ratio    = ($product->first_installment_ratio) ? ($product->first_installment_ratio*0.01):0.33;

        $final_installment_date     = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            ($product->final_installment_date ?:'2020-01-21 00:00:00')
        ); // 15 esfand


        //include VAT amount  + 5% installment
        $product_price = $this->getInstallmentPrice();

        $installment_array = [];

        //check if this product can have installments
        $installment_array[0]['date'] = Carbon::now();

        //first Installment
        $installment_array[0]['amount'] = (int) ($product_price * $first_installment_ratio);
        //middle Installments
        $sum_installment_array=$installment_array[0]['amount'];
        for ($i=1; $i < $installment_count-1 ; $i++) {

            //set date of Installment
            $differ_timestamp_total = $final_installment_date->timestamp - Carbon::now()->timestamp;
            $differ_timestamp_period = (int) ($differ_timestamp_total/($installment_count-1));
            $installment_array[$i]['date'] = Carbon::createFromTimestamp(Carbon::now()->timestamp + ($differ_timestamp_period * $i));

            //set amount of Installment
            $installment_array[$i]['amount'] = (int) ((($product_price - $installment_array[0]['amount'])/($installment_count-1)));
            $sum_installment_array += $installment_array[$i]['amount'];
        }

        //last Installment
        $installment_array[$installment_count-1]['date'] = $final_installment_date;
        $installment_array[$installment_count-1]['amount'] = (int) ($product_price - $sum_installment_array);

        return $installment_array;
    }

    public function getInstallmentPrice(): int
    {
        $result= $this->cartItem->getPrice();
        return (int) ceil($result);
    }

}
