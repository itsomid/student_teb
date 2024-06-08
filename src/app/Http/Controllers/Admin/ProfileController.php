<?php

namespace App\Http\Controllers\Admin;

use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        return view('dashboard.profile.edit',['admin'=>$admin]);
    }

    public function update(Admin $admin,Request $request)
    {

        $this->validate($request, [
            'first_name'    =>  ['required', 'max:30'],
            'last_name'     =>  ['required', 'max:30'],
            'email'         =>  ['nullable', 'email'],
        ]);

        $admin->first_name  = $request->first_name;
        $admin->last_name   = $request->last_name;
        $admin->gender      = $request->gender;
        $admin->email       = $request->email;
        $admin->instagram   = $request->instagram;
        $admin->telegram    = $request->telegram;
        $admin->whatsapp    = $request->whatsapp;

        $admin->save();
        Toast::message('اطلاعات شما با موفقیت ویرایش شد.')->success()->notify();
        return redirect()->back();
    }

    public function passwordEdit()
    {
        $admin = Auth::guard('admin')->user();
        return view('dashboard.profile.edit_password',['admin'=>$admin]);
    }

    public function passwordUpdate(Admin $admin,Request $request)
    {
        $this->validate($request, [
            'password' => ['required','confirmed','min:8']
        ]);

        $admin->password = Hash::make($request->password);
        $admin->save();
        Toast::message('رمز عبور شما با موفقیت تغییر کرد.')->success()->notify();
        return redirect()->back();
    }

    public function twoFAEdit()
    {
        return view('dashboard.profile.edit_2fa');
    }
}
