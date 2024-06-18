<?php

use App\Http\Controllers\API\Auth\CheckRegistrationController;
use App\Http\Controllers\API\Auth\LockTimeController;
use App\Http\Controllers\API\Auth\OTPLoginVerifyController;
use App\Http\Controllers\API\Auth\OTPRegisterVerifyController;
use App\Http\Controllers\API\Auth\PasswordLoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\ReloadCaptchaController;
use App\Http\Controllers\API\Auth\SendOTPController;
use App\Http\Controllers\API\StoreController;

use App\Http\Controllers\API\CartController;
use Illuminate\Support\Facades\Route;

Route::post('auth',             [CheckRegistrationController::class,       '__invoke']);

Route::post('password_login',   [PasswordLoginController::class,           '__invoke']);

Route::post('send_otp',         [SendOTPController::class,                 '__invoke']);

Route::post('otp_login',        [OTPLoginVerifyController::class,          '__invoke']);
Route::post('otp_register',     [OTPRegisterVerifyController::class,       '__invoke']);

Route::post('registering',      [RegisterController::class,                '__invoke']);

Route::get('captcha_reload',    [ReloadCaptchaController::class,           '__invoke']);
Route::post('lock_time',        [LockTimeController::class,                '__invoke']);

Route::middleware('checkJWT')->group(callback: function () {

    Route::get('/store', [StoreController::class, 'store']);
    Route::get('/store/product-detail/{product}', [StoreController::class, 'storeItem']);

    //Cart
    Route::post('/carts/add', [CartController::class, 'add']);
    Route::delete('/carts/{product}/remove', [CartController::class, 'remove']);
    Route::post('/carts/change-installment', [CartController::class, 'changeToInstallmentCart']);
    Route::get('/carts', [CartController::class, 'lists']);
});


