<?php
Route::prefix('gbv')->group(function () {
    Route::get('/layouts/dashboard', function () {
        return view('dashboard.gbv.dashboard');
    })->name('gbv.dashboard');
});
