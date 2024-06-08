<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminCollection;
use App\Models\Admin;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {

        $admins = request()->has('role')
            ? Admin::query()->select('id', 'first_name', 'last_name', 'mobile')->role(request()->input('role'))->latest()->get()
            : Admin::query()->select('id', 'first_name', 'last_name', 'mobile')->latest()->get();

        $admins= new  AdminCollection($admins);

        return response()->json($admins);
    }

    public function search()
    {
        $admins = User::query()
            ->select('id', 'first_name', 'last_name', 'mobile')
            ->where('first_name', 'LIKE', '%'.request()->input('user').'%')
            ->orWhere('last_name',  'LIKE', '%'.request()->input('user').'%')
            ->orWhere('mobile',     'LIKE', '%'.request()->input('user').'%')
            ->latest()
            ->take(10)
            ->get();

        $admins= new  AdminCollection($admins);

        return response()->json($admins);
    }
}
