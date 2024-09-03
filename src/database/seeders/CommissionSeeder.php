<?php

namespace Database\Seeders;

use App\Models\CommissionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    private array $commission_types=
        [
            [
                'title' => 'سرپرست',
                'percentage' => 0.0413,
                'specification' => 'ALL',
            ],
            [
                'title' => 'فروشنده پایه',
                'percentage' => 0.0375	,
                'specification' => 'ELEMENTARY',
            ],
            [
                'title' => 'فروشنده شهرستان',
                'percentage' => 0.4,
                'specification' => 'ALL',
            ],
            [
                'title' => 'فروشنده شهرستان',
                'percentage' => 0.3,
                'specification' => 'ALL',
            ],
            [
                'title' => 'فروشنده دورکار',
                'percentage' => 0.0318	,
                'specification' => 'ALL',
            ],
            [
                'title' => 'فروشنده هیبرید',
                'percentage' => 0.035,
                'specification' => 'ALL',
            ],
            [
                'title' => 'فروشنده حضوری',
                'percentage' => 0.0375,
                'specification' => 'ALL',
            ],
            [
                'title' => 'قطع همکاری',
                'percentage' => 0,
                'specification' => 'ALL',
            ],
        ];
    public function run(): void
    {
        foreach($this->commission_types as $commission_type){
            CommissionType::query()->create($commission_type);
        }
    }
}
