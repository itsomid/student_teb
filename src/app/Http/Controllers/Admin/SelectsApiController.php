<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelectsApiController extends Controller
{
    public function students()
    {
        return \App\Models\User::query()
            ->select('id', 'name', 'mobile')
            ->where('name', 'LIKE', '%'.request()->input('term').'%')
            ->orWhere('mobile', 'LIKE', '%'.request()->input('term').'%')
            ->get()->toJson();
    }

    public function admins()
    {
        return \App\Models\Admin::query()
            ->select('id', 'first_name', 'last_name', 'mobile')
            ->where('first_name', 'LIKE', '%'.request()->input('term').'%')
            ->orWhere('last_name', 'LIKE', '%'.request()->input('term').'%')
            ->orWhere('mobile', 'LIKE', '%'.request()->input('term').'%')
            ->get()->toJson();
    }
}
