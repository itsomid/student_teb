<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Database\Factories\CouponFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoupanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coupon::factory(10)->create();
    }
}
