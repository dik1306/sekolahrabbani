<?php

use App\Http\Controllers\KarirController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [UserController::class, 'index'])->name('login');
    Route::post('login', [UserController::class, 'customLogin'])->name('login.post');
    Route::get('register', [UserController::class, 'register'])->name('register');
    Route::post('register', [UserController::class, 'customRegistration'])->name('register.post');
    Route::get('verifikasi', [UserController::class, 'verifikasi'])->name('verifikasi');
    Route::post('verifikasi', [UserController::class, 'store_verifikasi'])->name('verifikasi.post');
    Route::get('/karir/login', [KarirController::class, 'login'])->name('karir.login');
    Route::get('/karir/verifikasi', [KarirController::class, 'verifikasi'])->name('karir.verifikasi');
    Route::post('/karir/login', [KarirController::class, 'store_login'])->name('karir.store_login');
    Route::post('/karir/verifikasi', [KarirController::class, 'store_verifikasi'])->name('karir.store_verifikasi');
});

Route::middleware('auth')->group(function () {
    Route::post('signout', [UserController::class, 'logout'])->name('logout');
    Route::post('/karir/logout', [KarirController::class, 'logout'])->name('karir.logout');

    Route::get('/send-notification-page', function() {
        return view('auth.send_wa_test');
    });
    Route::post('/send-notification', [UserController::class, 'send_notif']);


});
