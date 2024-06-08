<?php

namespace Database\Seeders;

use App\Data\PermissionList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        foreach (PermissionList::get() as $permission)
            Permission::create([
                'name' => $permission[0],
                'persian_name' => $permission[1],
            ]);


        $role = Role::query()->where('name', 'admin')->first();
        $permissions = Permission::all();
        foreach ($permissions as $permission)
            $role->givePermissionTo($permission->name);



        $role_sale_support = Role::query()->where('name', 'sales_support')->first();
        $role_sale_support->givePermissionTo(['student.index','student.edit','student.edit-support']);

        $role_sale_representative = Role::query()->where('name', 'sales_representative')->first();
        $role_sale_representative->givePermissionTo('report.registered_users');
    }
}
