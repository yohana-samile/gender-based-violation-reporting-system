<?php
    Route::group([
        'namespace' => 'Frontend',
        'prefix' => 'frontend',
        'as' => 'frontend.'
    ], function() {

        Route::group([ 'prefix' => 'profile',  'as' => 'profile.'], function() {
            Route::get('/profile-show', 'SettingController@profileShow')->name('show');
            Route::post('/update-password', 'SettingController@updatePassword')->name('update.password');
        });
    })->middleware('access.routeNeedsPermission:manage_emails');
