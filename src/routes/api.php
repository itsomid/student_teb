<?php

use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\DebitCardTransactionController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\StudentController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CartController;
use Illuminate\Support\Facades\Route;

Route::post('/cart/{product}/add', [CartController::class, 'add']);
Route::delete('/cart/{product}/remove', [CartController::class, 'remove']);
Route::post('/cart/change-installment', [CartController::class, 'changeToInstallmentCart']);

Route::name('api.')->group(callback: function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/search', [UserController::class, 'search'])->name('user.search');

    Route::get('/students', [StudentController::class, 'index'])->name('student.index');

    Route::get('/students/{student}/sales_description', [StudentController::class, 'note'])->name('student.get-note');
    Route::patch('/students/{student}/update_sales_description', [StudentController::class, 'updateNote'])->name('student.update-note');

    Route::patch('/debit-cards/{debit_card}', [DebitCardTransactionController::class, 'updateStatus'])->name('debit-card.update-status');
    Route::get('/course/search', [CourseController::class, 'search'])->name('course.search');
    Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');


});

