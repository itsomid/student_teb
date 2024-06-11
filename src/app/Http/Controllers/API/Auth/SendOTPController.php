<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\KavenegarVerificationSMS;
use App\Models\User;
use App\Models\VerificationCode;
use App\Models\VerifyUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SendOTPController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,[
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
        ]);

        $user_mobile = $request->mobile;

        $lockTimeSec = 60;

        $user = User::firstOrCreate(['mobile' => $user_mobile]);

        if ($user->sms_wrong_sms_tries > 20)
            $lockTimeSec = 1200;


        if ($user->isLocked())
            return response(['opt_result' => false ], Response::HTTP_LOCKED);


        // Generate token
        $token= $user->canGenerateToken()
            ? $user->generateToken()
            : $user->sms_token;

        // Save token
        $verifyUser = VerificationCode::create([
            'mobile'=> $user_mobile,
            'token' => $token,
            'ip'    => $request->ip(),
        ]);

        // Update user
        $user->sms_token = $token;
        $user->sms_lock_until = Carbon::now()->addSeconds($lockTimeSec);
        $user->sms_wrong_sms_tries++;
        $user->sms_this_token_tries = 0;

        $user->save();

        $this->sendSmsKaveNegar($verifyUser);

        return response(['opt_result' => true ], Response::HTTP_CREATED);
    }


    public function sendSmsKaveNegar($verifyUser)
    {
        if (env('APP_ENV') !== 'local') {
            KavenegarVerificationSMS::dispatch($verifyUser);
        }
    }
}
