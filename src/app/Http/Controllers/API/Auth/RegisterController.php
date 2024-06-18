<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use app\Http\Requests\API\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\JWT;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {

        $user = User::where('mobile', $request->mobile)->first();
        if ($user) {
            if ($user->mobile && $user->name) {
                return response([
                    'message' => 'You have already registered'
                ], Response::HTTP_CONFLICT);
            }
            if (!$user->verified) {
                return response([
                    'message' => 'You does not verify your mobile',
                ], Response::HTTP_FORBIDDEN);
            }
        }

        $user->name = $request->name;
        $user->grade = $request->grade;
        $user->field_of_study = $request->field_of_study;
        $user->verified_by_supporter = 1;
        $user->save();

        //TODO: Enable remove code
//        VerificationCode::query()->where('receptor', $user->mobile)->delete();
        return response([
            'token' => JWT::new()
                ->payload(VerificationCode::getPayload($user->id))
                ->encode(),
            'user' => new UserResource($user)
        ], Response::HTTP_CREATED);

    }
}
