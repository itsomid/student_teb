<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Filter;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserSupport;

class UserSupportController extends Controller
{
    public function index()
    {
        $filters= Filter::filter()
            ->add('user.name', request()->input('user_name'))
            ->add('end_time', request()->input('end_time'))
            ->add('start_time', request()->input('start_time'));

        $userSupports= UserSupport::index($filters->get());
        $admins= User::query()->with('roles')->get();

        return view('dashboard.user_support.index')
            ->with(['admins' => $admins])
            ->with(['userSupports' => $userSupports]);
    }
}
