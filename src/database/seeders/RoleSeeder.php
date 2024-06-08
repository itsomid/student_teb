<?php

namespace Database\Seeders;

use App\Data\PermissionList;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{

    public function run(): void
    {
        foreach ($this->data() as $role)
            Role::create([
                'name' => $role[0],
                'persian_name' => $role[1],
                'guard_name' => 'admin',
            ]);

    }

    private function data()
    {
        return [
            ['admin', 'مدیر ارشد'],
            ['sales_support', 'پشتیبان فروش'],
            ['sales_supervisor', 'سرپرست فروش'],
            ['sales_representative', 'نماینده فروش'],
            ['sales_manager', 'مدیر فروش'],
            ['studio_support', 'پشتیبان استودیو'],
            ['teacher', 'استاد'],
            ['teacher_assistant', 'دستیار استاد'],
            ['studio_manager', 'مدیر استودیو'],
            ['teacher_access_type_c', 'دسترسی سطح C استاد'],
            ['teacher_access_type_b', 'دسترسی سطح B استاد'],
            ['teacher_access_type_a', 'دسترسی سطح A استاد'],
            ['tech_analysis', 'تیم Tech (آنالیز)'],
            ['teacher_access_type_d', 'دسترسی سطح D استاد'],
            ['tech_support', 'پشتیبانی فنی (Tech)'],
            ['tech_developers', 'توسعه دهنده(Tech Developer)'],
        ];
    }
}
