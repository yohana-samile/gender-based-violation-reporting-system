<?php
    Route::group([
        'namespace' => 'Gbv',
        'prefix' => 'backend',
        'as' => 'backend.'
    ], function() {

        Route::group([ 'prefix' => 'profile',  'as' => 'profile.'], function() {
            Route::get('/profile-show', 'SettingController@profileShow')->name('show');
        });
    })->middleware('access.routeNeedsPermission:all_functions');
