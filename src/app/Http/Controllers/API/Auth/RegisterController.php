<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\VerificationCode;
use App\Models\VerifyUser;
use App\Models\User;
use App\Rules\RequestValidRule;
use App\Services\JWT;
use App\Services\Register;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        $this->validate($request,  [
            'mobile'            =>  'required|regex:/^09[0-9]{9}$/|exists:users,mobile',
            'name'              =>  'required|string|max:255',
            'reagent_code'      =>  'nullable|string|max:255',
            'grade'             =>  'required|in:12,11,10,9,8,7,6,5,4,3,2,1,ghadim',
            'field_of_study'    =>  'required|in:4,3,2,1,0',
            'sms_token'         =>  ['required','digits:5', 'bail',new RequestValidRule($request->mobile)],
        ]);
        $user = User::where('mobile', $request->mobile)->first();

        if (! is_null($user->id)) {
            return response([
                'message' => 'You have already registered'
            ], Response::HTTP_CONFLICT);
        }

        if (! $user->verified){
            return response([
                'message' => 'You does not verify your mobile',
            ], Response::HTTP_FORBIDDEN);
        }


        $register = new Register();
        $body = $register->add(
            $request->name,
            $request->mobile,
            $request->grade,
            $request->field_of_study,
            $request->get('reagent_code')
        );



        $user->name = $request->name;
        $user->id   = $body->id;
        $user->save();

        VerificationCode::query()->where('mobile', $user->mobile)->delete();

        return response([
            'token' => JWT::new()
                ->payload(VerificationCode::getPayload($user->id))
                ->encode(),
            'user' => new UserResource($user)
        ], Response::HTTP_CREATED);
    }
}
