<?php

use App\Http\Controllers\API\Auth\CheckRegistrationController;
use App\Http\Controllers\API\Auth\LockTimeController;
use App\Http\Controllers\API\Auth\OTPLoginVerifyController;
use App\Http\Controllers\API\Auth\OTPRegisterVerifyController;
use App\Http\Controllers\API\Auth\PasswordLoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\ReloadCaptchaController;
use App\Http\Controllers\API\Auth\SendOTPController;
use App\Http\Controllers\API\ClassController;
use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\StoreController;
use App\Http\Controllers\API\BuyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProfileController;

Route::get('auth',                 [CheckRegistrationController::class,    '__invoke']);

Route::post('password_login',       [PasswordLoginController::class,        '__invoke']);

Route::post('send_otp',             [SendOTPController::class,              '__invoke']);

Route::post('otp_login',            [OTPLoginVerifyController::class,       '__invoke']);
Route::post('otp_register',         [OTPRegisterVerifyController::class,    '__invoke']);

Route::post('registering',          [RegisterController::class,             '__invoke']);

Route::get('captcha_reload',        [ReloadCaptchaController::class,        '__invoke']);
Route::post('lock_time',            [LockTimeController::class,             '__invoke']);



Route::get('pay/cart/callback', [BuyController::class, 'cartCallback'])->name('bank.cart.callback');

Route::middleware('checkJWT')->group(callback: function () {

    Route::get('/store', [StoreController::class, 'store']);
    Route::get('/store/product-detail/{product}', [StoreController::class, 'storeItemDetails']);
    Route::get('/store/packages/{product}', [StoreController::class, 'packageShow']);

    Route::get('/cart', [CartController::class, 'lists'])->name('cart.lists');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('cart/package/update', [CartController::class, 'updatePackage']);
    Route::delete('/cart/remove/{product}', [CartController::class, 'remove']);
    Route::post('/cart/change-installment', [CartController::class, 'changeToInstallmentCart']);
    Route::post('/cart/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.apply-coupon');
    Route::patch('/cart/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.remove-coupon');
    Route::get('cart/buy', [BuyController::class, 'payCart']);

    Route::get('/user', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/user/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/user/update-password',[ProfileController::class, 'updatePassword']);
    Route::post('/user/update-avatar',[ProfileController::class, 'updateAvatar']);

    //Course
    Route::get('courses/my-courses', [CourseController::class, 'myCourses'])->name('courses.my-courses');
    Route::get('courses/{course_id}/classes', [CourseController::class, 'classes'])->name('courses.classes');
    Route::get('courses/classes/{class_id}', [ClassController::class, 'show'])->name('courses.classes.show');

});

Route::name('api.')->group(callback: function () {
    Route::get('/students/{student}/sales_description', [StudentController::class, 'note'])->name('student.get-note');
    Route::patch('/students/{student}/update_sales_description', [StudentController::class, 'updateNote'])->name('student.update-note');
});

