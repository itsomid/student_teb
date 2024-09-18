<?php

namespace Database\Seeders;

use App\Enums\CommissionSpecificationTypeEnum;
use App\Models\Admin;
use App\Models\CommissionType;
use Illuminate\Database\Seeder;

class CommissionSeeder extends Seeder
{
    private array $commission_types=
        [
            [
                'title' => 'سرپرست',
                'percentage' => 0.0413,
                'specification' => CommissionSpecificationTypeEnum::ALL,
            ],
            [
                'title' => 'فروشنده پایه',
                'percentage' => 0.0375	,
                'specification' => CommissionSpecificationTypeEnum::ELEMENTARY,
            ],
            [
                'title' => 'فروشنده شهرستان',
                'percentage' => 0.4,
                'specification' => CommissionSpecificationTypeEnum::NonCapital,
            ],
            [
                'title' => 'فروشنده شهرستان',
                'percentage' => 0.3,
                'specification' => CommissionSpecificationTypeEnum::NonCapital,
            ],
            [
                'title' => 'فروشنده دورکار',
                'percentage' => 0.0318	,
                'specification' => CommissionSpecificationTypeEnum::ALL,
            ],
            [
                'title' => 'فروشنده هیبرید',
                'percentage' => 0.035,
                'specification' => CommissionSpecificationTypeEnum::ALL,
            ],
            [
                'title' => 'فروشنده حضوری',
                'percentage' => 0.0375,
                'specification' => CommissionSpecificationTypeEnum::ALL,
            ],
            [
                'title' => 'قطع همکاری',
                'percentage' => 0,
                'specification' => CommissionSpecificationTypeEnum::ALL,
            ],
        ];
    public function run(): void
    {
        foreach($this->commission_types as $commission_type){
            $type = CommissionType::query()->create($commission_type);
            $type->commissions()->create([
                'support_id' => Admin::query()->inRandomOrder()->first()->id,
            ]);
        }
    }
}
