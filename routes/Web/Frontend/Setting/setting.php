<?php
    Route::group([
        'namespace' => 'Frontend',
        'prefix' => 'frontend',
        'as' => 'frontend.'
    ], function() {

        Route::group([ 'prefix' => 'profile',  'as' => 'profile.'], function() {
            Route::get('/profile-show', 'SettingController@profileShow')->name('show');
            Route::get('/update-password', 'SettingController@updatePassword')->name('update.password');

            Route::get('/setting', 'SettingController@setting')->name('setting');
            Route::get('/cpanel-token-update', 'SettingController@updateCpanelToken')->name('cpanel.token.update');
        });
    })->middleware('access.routeNeedsPermission:manage_emails');
