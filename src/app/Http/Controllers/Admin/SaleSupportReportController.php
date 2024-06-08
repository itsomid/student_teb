<?php

namespace App\Http\Controllers\Admin;

use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\ReferralCode;
use App\Models\RegisterVerificationHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleSupportReportController extends Controller
{
    public function registeredUsers()
    {
        $admin = Auth::guard('admin')->user();
        $referral_code = ReferralCode::where('admin_id',$admin->id)->first();

        if (!$referral_code && !$admin->can('student.manage-all-user')){
            Toast::message('شما هنوز کد معرفی برای مشاهده محتویات این صفحه ندارید.')->danger()->notify();
        }

        $students = User::checkPermissionToGetRefferalUser(Auth::guard('admin')->user(),$referral_code)->get();


        return view('dashboard.report.sale_support.registered_users',['students'=>$students]);
    }
    public function verificationHistory(User $student)
    {
        $records= RegisterVerificationHistory::query()
            ->where('student_id' , $student->id)
            ->with('admin')
            ->with('student')
            ->latest()
            ->get();

        return view('dashboard.report.sale_support.verification_history')
            ->with('student' , $student)
            ->with('records' , $records);
    }

}
