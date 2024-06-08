<?php

namespace App\Http\Controllers\Admin;


use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\ReferralCode;
use App\Models\RegisterVerificationHistory;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {

        $verified_students_count = User::CheckPermissionToGetList(Auth::guard('admin')->user())->where('verified_by_supporter',1)->count();
        $students = User::CheckPermissionToGetList(Auth::guard('admin')->user())->with('saleSupport')->with('referrer.admin')->orderBy('id')->filterBy(request()->all())->paginate(50);
        $referral_codes = ReferralCode::all();

        $salesDescriptions = User::CheckPermissionToGetList(Auth::guard('admin')->user())
            ->select('sales_description')
            ->whereNotNull('sales_description')
            ->groupBy('sales_description')
            ->get();

        return view('dashboard.student.index')
            ->with(['referral_codes' => $referral_codes])
            ->with(['verified_students_count' => $verified_students_count])
            ->with(['students' => $students])
            ->with(['salesDescriptions' => $salesDescriptions]);
    }

    public function create()
    {

        $sales_support = Admin::checkPermissionToGetSalesSupportList(Auth::guard('admin')->user())->select('id', 'first_name', 'last_name', 'mobile')->get();

        return view('dashboard.student.create')
            ->with(['sales_support' => $sales_support]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'mobile' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11','unique:users,mobile'],
        ]);
        User::query()->create([
            'name'                  => $request->name,
            'name_english'          => $request->name_english,
            'mobile'                => $request->mobile,
            'city'                  => $request->city,
            'province'              => $request->province,
            'field_of_study'        => $request->field_of_study,
            'familiarity_way'       => $request->familiarity_way,
            'verified'              => $request->verified,
            'sale_support_id'       => $request->sale_support_id,
            'password'              => Hash::make($request->password),
            'description'           => $request->description,
            'block'                 => $request->block,
            'gender'                => $request->gender,
        ]);

        Toast::message('افزودن دانش آموز با موفقیت انجام شد')->success()->notify();
        return redirect()->route('admin.student.index');
    }

    public function edit(User $student)
    {

        $sales_support = Admin::checkPermissionToGetSalesSupportList(Auth::guard('admin')->user())->select('id', 'first_name', 'last_name', 'mobile')->get();
        return view('dashboard.student.edit')
            ->with(['student' => $student])
            ->with(['sales_support'  => $sales_support]);
    }
    public function update(Request $request, User $student)
    {
        $student->update([
            'name'                    => $request->name,
            'name_english'            => $request->name_english,
            'city'                    => $request->city,
            'province'                => $request->province,
            'field_of_study'          => $request->field_of_study,
            'familiarity_way'         => $request->familiarity_way,
            'verified'                => $request->verified,
            'sale_support_id'         => $request->sale_support_id,
            'sales_description'       => $request->sales_description,
            'password'                => ($request->has('password') && !is_null($request->password)) ? Hash::make($request->password) : $student->password,
            'description'             => $request->description,
            'block'                   => $request->block,
            'block_reason_description'=> $request->block_reason_description,
            'gender'                  => $request->gender,
        ]);

        Toast::message('ویرایش دانش آموز با موفقیت انجام شد')->success()->notify();
        return redirect()->route('admin.student.index');
    }

    public function editSupport($student)
    {
        $student = User::find($student);
        return view('dashboard.student.support.edit')
            ->with(['student' => $student]);
    }

    public function editSupportSMS($student, Request $request)
    {
        $student = User::find($student);
        $support = Admin::query()->where('id', $request->user_id)->firstOrFail();

        $code = rand(100000, 999999);

        VerificationCode::query()->create([
            'receptor' => $support->mobile,
            'code' => $code,
            'expire_at' => now()->addMinutes(2)
        ]);

//        Kavenegar::to($support->mobile)->sendLookUp('auth', $code);

        return redirect()->route('admin.student.edit-support', ['student' => $student->id, 'sms' => 'sent', 'support_id' => $support->id])
            ->with('success','یک پیامک حاوی کد تایید برای پشتیبان انتخاب شده ارسال شد');
    }


    public function updateSupport(User $student, Request $request)
    {
        $new_support = Admin::query()->where('id', $request->support_id)->firstOrFail();
        $is_verified = VerificationCode::query()
            ->where('receptor', $new_support->mobile)
            ->whereDate('expire_at', '>=', now())
            ->where('code', $request->code)
            ->exists();

        if (!$is_verified)
            return redirect()->back()->withErrors(['code' => 'کد وارد شده صحیح نمیباشد']);

        $student->sale_support_id = $new_support->id;
        $student->save();

        return redirect()->back()->with('success','تغییر پشتیبان با مپفقیت انجام شد');
    }

    public function verifyStudent(User $student)
    {
        $student->verified_by_supporter= !$student->verified_by_supporter;
        $student->save();

        RegisterVerificationHistory::query()->create([
            'student_id' => $student->id,
            'admin_id'   => auth('admin')->id(),
            'action'     => $student->verified_by_supporter ? 'verified' : 'unverified',
        ]);

        return redirect()->back();
    }

}
