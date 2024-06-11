<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LockTimeController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,[
            'mobile' => 'required|regex:/^09[0-9]{9}$/',
        ]);

        $user_mobile = $request->mobile;

        $user = User::firstOrCreate(
            ['mobile' => $user_mobile]
        );

        return now()->lte($user->sms_lock_until)
            ? response(['lockTime' => Carbon::parse($user->sms_lock_until)->diffInSeconds()], Response::HTTP_OK)
            : response(['lockTime' => 0], Response::HTTP_OK);
    }
}
