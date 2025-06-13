<?php
    Route::prefix('frontend')->middleware('access.routeNeedsPermission:manage_emails')->group(function () {
        Route::get('/layouts/dashboard', function () {
            return view('dashboard.frontend.dashboard');
        })->name('frontend.dashboard');

    });

    Route::prefix('backend')->middleware('access.routeNeedsPermission:all_functions')->group(function () {
        Route::get('/layouts/dashboard', function () {
            return view('dashboard.backend.dashboard');
        })->name('backend.dashboard');
    });
