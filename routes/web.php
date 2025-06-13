<?php

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::group(['middleware' => 'web'], function () {
    Route::prefix('password')->group(function () {
        Route::get('request', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotPassForm'])->name('password.request');
        Route::get('reset/{token}', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'reset'])->name('password.update');
        Route::post('email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendPasswordResetLink'])->name('password.email');

        Route::post('resend', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verificationSend'])->name('verification.send');
        Route::post('confirm', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'passwordConfirm'])->name('password.confirm');
        Route::post('challenge', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'twoFactorChallenge'])->name('two-factor.login');
    });

    Route::get('/email/verify/{id}/{hash}', function (Request $request) {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect(user()->is_super_admin ? '/backend/layouts/dashboard' : '/frontend/layouts/dashboard');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        return redirect(user()->is_super_admin ? '/backend/layouts/dashboard' : '/frontend/layouts/dashboard');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('signup', [\App\Http\Controllers\Auth\RegisterController::class, 'signup'])->name('signup');
    Route::post('log_me_in', [\App\Http\Controllers\Auth\LoginController::class, 'logMeIn'])->name('log_me_in');
    Route::post('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/', [\App\Http\Controllers\Backend\AdminController::class, 'landing']);
    Route::get('dashboard', [\App\Http\Controllers\Backend\AdminController::class, 'dashboard'])->name("home");

    Route::group(['middleware' => 'web'], function () {
        Route::group(['middleware' => 'dashboard'], function () {
            Route::group(['middleware' => 'csrf'], function () {
                Route::group([ 'prefix' => ''], function() {

                    includeRouteFiles(__DIR__ . '/Web/');
                });
            });
        });
    });
});
