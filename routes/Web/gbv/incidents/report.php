<?php
Route::group([
    'namespace' => 'Gbv',
    'prefix' => 'gbv',
    'as' => 'gbv.'
], function () {
    Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
        Route::get('/reports', 'ReportController@reports')->name('reports');
    });
})->middleware('access.routeNeedsPermission:case_worker');
