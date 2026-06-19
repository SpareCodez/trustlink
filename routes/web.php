<?php

use App\Enums\UserPermission;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegistrationOtpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerchantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/register/otp', RegistrationOtpController::class)
    ->middleware(['guest', 'throttle:3,1'])
    ->name('register.otp');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/merchant/{user}', [MerchantController::class, 'show'])->name('merchant.show');

Route::prefix('admin')->name('admin.')->middleware([
    'auth',
    'permission:'.UserPermission::AccessAdmin->value,
])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
});
