<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserHistorySupport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(2)->create();
        User::factory(1)->unverifiedWithIncompleteRegistration()->create();
        User::factory(1)->unverified()->create();
        UserHistorySupport::factory(10)->create();

    }


}
