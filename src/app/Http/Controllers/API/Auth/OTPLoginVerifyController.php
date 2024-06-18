<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use app\Http\Requests\API\Auth\OTPLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\JWT;
use Illuminate\Http\Response;

class OTPLoginVerifyController extends Controller
{
    public function __invoke(OTPLoginRequest $request)
    {

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
        $user->verified = true;
        $user->save();

        VerificationCode::query()->where('receptor', $user->mobile)->delete();

        //Give JWT
        return response([
            'token' => JWT::new()->payload(VerificationCode::getPayload($user->id))->encode(),
            'user'  => new UserResource($user)
        ]);
    }

}
