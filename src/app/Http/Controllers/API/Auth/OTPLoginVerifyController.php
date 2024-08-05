<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\API\Auth\OTPLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jenssegers\Agent\Agent;

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

        if ($user->tokens()->count() >= User::MAX_TOKENS) {
            return response()->json([
                'message' => 'شما نمیتوانید با بیش از ' . User::MAX_TOKENS . ' دستگاه وارد شوید.'
            ], 403);
        }

        $token = $user->createToken((new Agent)->isMobile() ? 'Mobile' : 'Desktop');
        $user->setDetailOnToken($token);

        //Give JWT
        return response([
            'token' =>  $token->plainTextToken,
            'user'  => new UserResource($user)
        ]);
    }

}
