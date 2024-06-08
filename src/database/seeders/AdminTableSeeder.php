<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{

    const DEFAULT_SUPERVISOR = 1;

    public function run(): void
    {
        foreach ($this->admin() as $admin) {
            $admin = Admin::query()->create(array_merge($admin, [
                'password' => Hash::make('classino1234'),
                'gender' => 'male',
            ]));

            $admin->assignRole('admin');
        }
        foreach ($this->supervisor() as $admin) {
            $admin = Admin::query()->create(array_merge($admin, [
                'password' => Hash::make('classino1234'),
                'gender' => 'female',
            ]));

            $admin->assignRole('sales_supervisor');
        }
        foreach ($this->sales_support() as $admin) {
            $admin = Admin::query()->create(array_merge($admin, [
                'password' => Hash::make('classino1234'),
                'gender' => 'female',
            ]));

            $admin->assignRole('sales_support');
        }

    }

    private function admin(): array
    {
        return [
            [
                'id' => 1,
                'first_name' => 'کلاسینو',
                'last_name' => ' ',
                'email' => 'info@classino.com',
                'mobile' => '091219909744',
                'supervisor_id' => self::DEFAULT_SUPERVISOR
            ],
            [
                'id' => 2,
                'first_name' => 'امید',
                'last_name' => 'شبانی',
                'email' => 'o.shabani@hotmail.com.com',
                'mobile' => '09121990974',
                'supervisor_id' => self::DEFAULT_SUPERVISOR
            ],
            [
                'id' => 3,
                'first_name' => 'ارسلان',
                'last_name' => 'هاشمی پناه',
                'email' => 'arsalan@gmail.com',
                'mobile' => '09125260985',
                'supervisor_id' => self::DEFAULT_SUPERVISOR
            ],
            [
                'id' => 4,
                'first_name' => 'مهدی',
                'last_name' => 'غلامرضایی',
                'email' => 'mehdi@gmail.com',
                'mobile' => '09121118544',
                'supervisor_id' => self::DEFAULT_SUPERVISOR
            ],
        ];
    }

    private function supervisor(): array
    {
        return [
            [
                'id' => 5,
                'first_name' => 'شبنم',
                'last_name' => 'رئوفی',
                'email' => 'shabnam.raoufi@gmail.com',
                'mobile' => '09936061951',
                'supervisor_id' => self::DEFAULT_SUPERVISOR
            ],
        ];
    }
    private function sales_support(): array
    {
        return [

            [
                'id' => 6,
                'first_name' => 'فاطمه',
                'last_name' => 'فاضلی',
                'email' => 'fazeli@gmail.com',
                'mobile' => '09913233751',
                'supervisor_id' => 5
            ],
            [
                'id' => 7,
                'first_name' => 'گلناز',
                'last_name' => 'فرهمند',
                'email' => 'farahmand@gmail.com',
                'mobile' => '09399297035',
                'supervisor_id' => 5
            ],
            [
                'id' => 8,
                'first_name' => 'سهراب',
                'last_name' => 'کلانتری',
                'email' => 'sohrab.kalantari@gmail.com',
                'mobile' => '09019887964',
                'supervisor_id' => 5
            ],
            [
                'id' => 9,
                'first_name' => 'روژان',
                'last_name' => 'رونقگیر',
                'email' => 'rojan.ronaghgir@gmail.com',
                'mobile' => '09351064207',
                'supervisor_id' => 5
            ],
            [
                'id' => 10,
                'first_name' => 'شیوا',
                'last_name' => 'ربیعی',
                'email' => 'shiva.rabiei@gmail.com',
                'mobile' => '09056723953',
                'supervisor_id' => 5
            ],
        ];
    }
}
