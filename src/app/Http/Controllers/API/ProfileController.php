<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\UpdateAvatarRequest;
use App\Http\Requests\API\Auth\UpdatePasswordRequest;
use App\Http\Requests\API\User\ProfileUpdateRequest;
use App\Http\Resources\StudentPanel\UserProfileResourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = User::query()->where('id', auth('student')->id())->first();

        return response()->json([
            "data" => new UserProfileResourse($user),
        ], 200);
    }

    public function update(Request $request)
    {

        if ($request->input('province') == 0) $request->merge(['province' => null]);
        if ($request->input('city') == 0) $request->merge(['city' => null]);
        if ($request->input('grade') === 0) $request->merge(['grade' => null]);


        $user = Auth::guard('student')->user();

        $user->name = $request->name;
        $user->name_english = $request->name_english;

        // for external image source
        $oldImage = $user->profile_img;
        if ($request->has('profile_img')) {

            $timestamp = now()->timestamp;
            $imageName = $user->id . '_' . Str::random(5) . '_' . $timestamp . '.' . $request->file('profile_img')->getClientOriginalExtension();
            $request->file('profile_img')->storeAs('users', $imageName, ['disk' => 'public']);
            $user->update(['profile_img' => $imageName]);
        }

        if ($request->province != 0 && $request->province != "0") {
            $user->province = $request->province;
        }
        if ($request->city != 0 && $request->city != "0") {
            $user->city = $request->city;
        }
        $user->grade = $request->grade;
        $user->gender = $request->gender;
        $user->field_of_study = $request->field_of_study;
        $user->familiarity_way = $request->familiarity_way;

        $user->save();

        if ($request->hasFile('profile_img') && $oldImage) {
            $oldImagePath = 'users/' . $oldImage;
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }
        // Profile updated successfully
        return response()->json(
            ['message' => 'پروفایل شما با موفقیت ویرایش شد.'],
            Response::HTTP_OK);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::guard('student')->user();

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'رمز عبور با موفقیت تغییر کرد.'], 200);

    }

    public function updateAvatar(UpdateAvatarRequest $request)
    {
        if ($request->hasFile('avatar')) {
            $user = Auth::guard('student')->user();
            $avatar = $request->file('avatar');
            $avatarFileName = $avatar->hashName();
            $avatarPath = $avatar->storeAs('students-avatar', $avatarFileName, 'public');

            // Delete the old avatar if it exists
            if ($user->profile_img) {
                Storage::disk('public')->delete('students-avatar/' . $user->profile_img);
            }

            // Update the user's avatar path in the database
            $user->profile_img = $avatarFileName;
            $user->save();

            return response()->json(['message' => 'عکس پروفایل شما با موفقیت تغییر کرد.', 'avatar_url' => Storage::url($avatarPath)], 200);
        }

        return response()->json(['message' => 'No avatar image uploaded.'], 400);
    }
}
