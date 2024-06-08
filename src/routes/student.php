<?php


use App\Http\Controllers\Student\Auth\UserOtpAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::get('auth/otp/login', [UserOtpAuthController::class, 'showLoginForm'])->name('auth.show-login-form')->middleware('guest_student');
Route::post('auth/otp/login', [UserOtpAuthController::class, 'login'])->name('auth.otp.login.post')->middleware('guest_student');

Route::get('auth/otp/verify', [UserOtpAuthController::class, 'showVerifyForm'])->name('auth.otp.verify')->middleware('guest_student');
Route::post('auth/otp/verify', [UserOtpAuthController::class, 'verify'])->name('auth.otp.verify.post')->middleware('guest_student');

Route::get('auth/otp/register', [UserOtpAuthController::class, 'showRegisterForm'])->name('auth.otp.register')->middleware('auth:student');
Route::post('auth/otp/register', [UserOtpAuthController::class, 'register'])->name('auth.otp.register.post')->middleware('auth:student');

Route::get('auth/otp/term_condition', [UserOtpAuthController::class, 'showTermConditionForm'])->name('auth.otp.term-condition')->middleware('auth:student');
Route::get('auth/otp/term_condition/agree', [UserOtpAuthController::class, 'agreeTermCondition'])->name('auth.otp.termCondition.agree')->middleware('auth:student');

Route::get('auth/logout', [UserOtpAuthController::class, 'logout'])->name('auth.logout')->middleware('auth:student');

Route::middleware(['auth:student', 'check_registration'])->group(function () {
    Route::get('/dashboard', function () {
        return view('student.index');
    })->name('dashboard');
});
    
