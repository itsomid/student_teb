<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;

use app\Http\Requests\API\Auth\PasswordLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class PasswordLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = User::where('mobile', $request->mobile)->first();

        // Check token
        if(!$user || (!Hash::check($request->password,$user->password)))
        {
            return response([
                'message' => 'نام کاربری یا رمز عبور اشتباه است.'
            ], Response::HTTP_FORBIDDEN);
        }

        if ($user->tokens()->count() >= User::MAX_TOKENS) {
            return response()->json([
                'message' => 'شما نمیتوانید با بیش از ' . User::MAX_TOKENS . ' دستگاه وارد شوید.'
            ], 403);
        }

        $token = $user->createToken((new Agent)->isMobile() ? 'Mobile' : 'Desktop');
        $user->setDetailOnToken($token);

        return response([
            'token' => $token->plainTextToken,
            'user'  => new UserResource($user)
        ]);
    }
}
