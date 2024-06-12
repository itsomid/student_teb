<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordLoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerificationCode;

use App\Services\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PasswordLoginController extends Controller
{
    public function __invoke(PasswordLoginRequest $request)
    {
        $user = User::where('mobile', $request->mobile)->first();

        // Check token
        if(!$user || (!Hash::check($request->password,$user->password)))
        {
            return response([
                'message' => 'نام کاربری یا رمز عبور اشتباه است.'
            ], Response::HTTP_FORBIDDEN);
        }

        $user->save();

        return response([
            'token' => JWT::new()
                ->payload(VerificationCode::getPayload($user->id))
                ->encode(),
            'user' => new UserResource($user)
        ]);
    }
}
