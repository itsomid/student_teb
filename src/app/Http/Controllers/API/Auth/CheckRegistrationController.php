<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Jenssegers\Agent\Agent;

class CheckRegistrationController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,[
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
        ]);

        $userAlreadyRegistered= !User::query()
            ->whereNotNull('name')
            ->whereMobile($request->mobile)
            ->whereVerified(true)
            ->exists();

        return response()->json([
            'is_new_user' => $userAlreadyRegistered
        ], Response::HTTP_OK);
    }
}
