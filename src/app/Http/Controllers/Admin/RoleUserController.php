<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleUserController extends Controller
{
    public function edit(Admin $admin)
    {
        $roles = Role::query()->orderBy('name')->get();
        return view('dashboard.admin.role.edit')
            ->with(['user'  => $admin])
            ->with(['roles' => $roles]);
    }

    public function update(Admin $admin, Request $request)
    {
        $admin->roles()->sync($request->roles);
        return redirect()->back();
    }
}
