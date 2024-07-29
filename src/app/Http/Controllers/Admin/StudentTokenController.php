<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentTokenController extends Controller
{
    public function index(User $student){
        $tokens= $student->tokens()->get();
        return view('dashboard.student.token.index')->with('tokens',$tokens)->with('student',$student);
    }
}
