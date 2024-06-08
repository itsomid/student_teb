<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CouponExport implements  FromArray, WithHeadings, WithColumnWidths
{

    protected  $coupons;

    public function __construct($coupons)
    {
        $this->coupons = $coupons;
    }

    public function array(): array
    {

         $items= $this->coupons->map(function ($item){
            return [
                $item->id,
                $item->creator_user->name,
                $item->coupon,
                $item->discount_percentage,
                $item->discount_amount,
                $item->description,
            ];
        });

        return $items->toArray();
    }

    public function headings(): array
    {
        return [
            'id',
            'سازنده',
            'کد',
            'درصد تخفیف',
            'میزان تخفیف',
            'توضیحات',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 25,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 150,
        ];
    }
}
