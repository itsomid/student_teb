<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\VerifyUser;
use App\Rules\RequestValidRule;
use App\Services\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class OTPRegisterVerifyController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,[
            'mobile' => 'required|digits:11',
            'token' => ['required', 'digits:5', 'bail', new RequestValidRule($request->mobile)],
        ]);

        $user = User::where('mobile', $request->mobile)->firstOrFail();

        // Add tries
        $user->increment('sms_this_token_tries');

        // Prevent too many tries
        if ($user->sms_this_token_tries > User::NEW_TOKEN_INTERVAL) {
            return response('', Response::HTTP_LOCKED);
        }

        // Check token
        if ($user->sms_token !== $request->token) {
            return response(['error' => 'کد وارد شده منقضی شده و یا اشتباه است.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user->sms_this_token_tries = 0;
        $user->sms_wrong_sms_tries = 0;
        $user->sms_lock_until = null;
        $user->sms_token = null;
        $user->ip = request()->getClientIp();
        $user->verified = true;
        $user->save();


        return response()->json(['verified' => true], Response::HTTP_OK);
    }

}
