<?php
    Route::group([
        'namespace' => 'Backend',
        'prefix' => 'backend',
        'as' => 'backend.'
    ], function() {

        Route::group([ 'prefix' => 'profile',  'as' => 'profile.'], function() {
            Route::get('/profile-show', 'SettingController@profileShow')->name('show');
        });
    })->middleware('access.routeNeedsPermission:all_functions');
