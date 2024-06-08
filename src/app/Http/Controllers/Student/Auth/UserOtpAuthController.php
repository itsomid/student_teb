<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\KavenegarVerificationSMS;
use App\Models\ReferralCode;
use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserOtpAuthController extends Controller
{
    //TODO :: MAYBE HERE SHOULD BE PLACED IN DYNAMIC CONFIG SETTINGS IN ADMIN PANEL
    private const NEW_TOKEN_INTERVAL = 30;
    private const REQUEST_ACCEPTED_COUNT_FROM_IP = 20;

    public function showLoginForm()
    {
        $referrer= ReferralCode::query()->where('code', request()->input('referrer', null))->with('admin')->first();

        return view('student.auth.mobile.mobile_login')
            ->with(['referrer' => $referrer]);
    }

    public function login(Request $request)
    {

        $request->validate([
            'mobile' => ['required', 'string', 'max:255', 'regex:/^09[0-9]{9}$/'],
        ]);

        $user= User::where('mobile', $request->mobile)->first();

        if (is_null($user) && request()->has('referrer'))
            session()->put('referrer_id', request()->input('referrer'));

        return redirect()->route('student.auth.otp.verify', ['mobile'=>$request->mobile]);
    }

    public function showVerifyForm(Request $request)
    {
         $request->validate([
            'mobile' => ['required', 'string', 'max:255', 'regex:/^09[0-9]{9}$/'],
        ]);


        $user_mobile = $request->input('mobile');

        $lockTimeSec = 60;

        $user = User::firstOrCreate(
            ['mobile' => $user_mobile],
            ['password' => Hash::make(rand()), 'verified' => 0]
        );

        //TODO :: MAYBE THIS NUMBERS SHOULD BE LOADED FROM DYNAMIC CONFIG SETTINGS IN ADMIN PANEL
        if ($user->sms_wrong_sms_tries > 20) {
            $lockTimeSec = 1200;
        }

        if ($user->sms_lock_until && Carbon::now()->lte($user->sms_lock_until)) {
            // Don't send sms and generate new token if locked
            $lockTimeSec = Carbon::now()->diffInSeconds($user->sms_lock_until);
        } else {
            // Generate token
            if (empty($user->sms_token) || $user->sms_this_token_tries >= self::NEW_TOKEN_INTERVAL) {
                 $token = generateMemorableVerificationCode();
            } else {
                $token = $user->sms_token;
            }
            // Save token
            $verifyUser = VerificationCode::create([
                'receptor' => $request->mobile,
                'code' => $token,
            ]);

            // Update user
            $user->sms_token = $token;
            $user->sms_lock_until = Carbon::now()->addSeconds($lockTimeSec);
            $user->sms_wrong_sms_tries++;
            $user->sms_this_token_tries = 0;

            $user->save();

            KavenegarVerificationSMS::dispatch($verifyUser)->onQueue('sms');
        }


        return view('student.auth.mobile.mobile_verify', [
            'wait_seconds_to_send_sms' => $lockTimeSec,
            'mobile' => $user_mobile,
        ]);
    }


    public function verify(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:11',
            'otp' => 'required|int',
        ]);

        $user = User::select([
            'id',
            'mobile',
            'sms_token',
            'sms_lock_until',
            'sms_this_token_tries',
            'sms_wrong_sms_tries'
        ])->where('mobile', $request->input('mobile'))
            ->firstOrFail();

        // Add tries
        $user->sms_this_token_tries++;
        $user->save();

        // Prevent too many tries
        if ($user->sms_this_token_tries > self::NEW_TOKEN_INTERVAL) {
            return redirect()->route('student.auth.otp.verify', ['mobile' => $request->input('mobile')])->with('error', 'پیامک دیگری برایتان ارسال شد');
        }

        // Check token
        $token = $request->input('otp');
        if ($user->sms_token != $token) {
            return redirect()->route('student.auth.otp.verify', ['mobile' => $request->input('mobile')])->with('error', 'کد وارد شده صحیح نمیباشد لطفا مجددا وارد کنید');
        }

        $user->sms_this_token_tries = 0;
        $user->sms_wrong_sms_tries = 0;
        $user->sms_lock_until = null;
        $user->sms_token = null;
        $user->save();

        Auth::guard('student')->login($user);

        return $this->redirectToDashboard();
    }

    public function showRegisterForm()
    {
        if (auth('student')->user()->name)
            return $this->redirectToDashboard();

        return view('student.auth.mobile.user_register');
    }

    public function register(Request $request)
    {
        if (auth('student')->user()->name)
            return $this->redirectToDashboard();

        $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'grade'             => ['required', 'in:13,12,11,10,9,8,7,6,5,4,3,2,1'],
            'field_of_study'    => ['required', 'in:5,4,3,2,1'],
        ], [
            'name.required'     => 'وارد کردن نام الزامی می باشد.',
            'name.max'          => 'طول نام وارد شده بیش از حد مجاز است.',
            'grade.required'    => 'لطفا پایه ی تحصیلی خود را وارد کنید',
            'grade.in'          => 'پایه ی تحصیلی انتخاب شده صحیح نمی باشد.',
            'field_of_study.in' => 'رشته ی تحصیلی وارد شده صحیح نمی باشد.',
        ]);

        $user = auth('student')->user();

        $user->name = $request->input('name');
        $user->grade= $request->input('grade');
        $user->field_of_study= $request->input('field_of_study');
        $user->verified = 1;
        $user->save();

        return $this->redirectToDashboard();
    }

    public function showTermConditionForm()
    {
        return view('student.auth.mobile.term_condition');
    }

    public function agreeTermCondition(Request $request)
    {
        $user = auth('student')->user();
        $user->verified = 1;

        //TODO :: MAYBE HERE SHOULD BE QUEUED TO CHECK, IF ALL CONSTRAINTS ARE SATISFIED, UPDATE USER CREDIT WITH GIFT AMOUNT.
        $user->referral_id = session()->has('referrer_id')
            ?  session()->get('referrer_id')
            : $user->referral_id;

        $user->save();

        return response()->json([
            'redirect_url' => $this->calculateRedirectRoute()
        ], 200);
    }

    public function logout()
    {
        auth('student')->logout();
        return redirect()->route('student.auth.show-login-form');
    }


    public function redirectToDashboard()
    {
        return  redirect()->route('student.dashboard');
    }

    public function calculateRedirectRoute()
    {
        return route('student.dashboard');
    }
}

