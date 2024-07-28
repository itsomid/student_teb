<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Admin;
use App\Models\ReferralCode;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    private const SALES_SUPPORT_ROLE = 'sales_support';
    private const SALES_REPRESENTATIVE_ROLE = 'sales_representative';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedRolesAndPermissions();
//        $this->seedAdminsWithReferralCodes();
        $this->seedAdditionalData();
    }

    private function seedRolesAndPermissions(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
        ]);
    }

    private function seedAdminsWithReferralCodes(): void
    {
        $this->createAdminWithReferralCode('سالار', 'قلی زاده', 'salar@gmail.com', '09190926072', self::SALES_SUPPORT_ROLE, 'salar');
        $this->createAdminWithReferralCode('مانی', 'رهنما', 'mani@gmail.com', '09190926071', self::SALES_REPRESENTATIVE_ROLE, 'mani');

        $this->createMultipleAdmins(self::SALES_SUPPORT_ROLE, 3);
        $this->createMultipleAdmins(self::SALES_REPRESENTATIVE_ROLE, 4);
    }

    private function createAdminWithReferralCode(string $firstName, string $lastName, string $email, string $mobile, string $role, string $code): void
    {
        Admin::factory()
            ->withCustomRole([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'mobile' => $mobile,
            ], $role)
            ->has(ReferralCode::factory()
                ->state(['code' => $code])
                ->has(User::factory()->withCustomSaleSupport($mobile)->count(rand(5, 8)), 'registered_users')
                ->count(1)
            )->create();
    }

    private function createMultipleAdmins(string $role, int $count): void
    {
        $admins = Admin::factory($count)
            ->has(ReferralCode::factory()
                ->has(User::factory()->count(rand(2, 5)), 'registered_users')
                ->count(1))
            ->create();

        foreach ($admins as $admin) {
            $admin->assignRole($role);
        }
    }


    private function seedAdditionalData(): void
    {
        $this->call([
            AdminTableSeeder::class,
            UserTableSeeder::class,
            SettingTableSeeder::class,
            ProductSeeder::class,
            CoupanSeeder::class,
            OrderSeeder::class,
            OrderItemSeeder::class,
            TransactionSeeder::class
        ]);
    }
}
