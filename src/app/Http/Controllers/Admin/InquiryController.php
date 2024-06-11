<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        return view('dashboard.inquiry_student.index');
    }

    public function submit()
    {
        request()->validate([
            'mobile' => ['required']
        ]);
        $mobile= request()->input('mobile');
        $student= User::query()->where('mobile', 'LIKE', '%'.$mobile.'%')->first();

        return view('dashboard.inquiry_student.index')->with([
            'student' => $student
        ]);
    }
}
