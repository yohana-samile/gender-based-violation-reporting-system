<?php
Route::group([
    'namespace' => 'Backend',
    'prefix' => 'backend',
    'as' => 'backend.'
], function () {
    Route::group(['prefix' => 'incident', 'as' => 'incident.'], function () {
        Route::get('/index', 'IncidentController@index')->name('index');
        Route::get('/create', 'IncidentController@create')->name('create');
        Route::post('/', 'IncidentController@store')->name('store');
        Route::get('/{incident}', 'IncidentController@show')->name('show');
        Route::get('/edit/{incident}', 'IncidentController@edit')->name('edit');
        Route::put('/{incident}', 'IncidentController@update')->name('update');
        Route::delete('/{incident}', 'IncidentController@destroy')->name('destroy');
        Route::post('/update-status/{incident}', 'IncidentController@updateStatus')->name('update-status');
        Route::post('/attach-services/{incident}', 'IncidentController@attachServices')->name('attach-services');
        Route::get('/reports', 'IncidentController@reports')->name('reports');
    });
})->middleware('access.routeNeedsPermission:case_worker');
