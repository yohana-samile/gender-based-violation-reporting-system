<?php
Route::group([
    'namespace' => 'Backend\Access',
    'prefix' => 'backend',
    'as' => 'backend.'
], function () {


    Route::group(['prefix' => 'role', 'as' => 'role.'], function () {

        Route::get('/index', 'RoleController@index')->name('index');
        Route::get('/create', 'RoleController@create')->name('create');
        Route::post('/store', 'RoleController@store')->name('store');
        Route::get('/edit/{role}', 'RoleController@edit')->name('edit');
        Route::put('/update/{role}', 'RoleController@update')->name('update');
        Route::get('/profile/{role}', 'RoleController@profile')->name('profile');
        Route::delete('/delete/{role}', 'RoleController@delete')->name('delete');
        Route::get('/roles/users/{role}', 'RoleController@users')->name('users');
        Route::get('/get_all_for_dt', 'RoleController@getAllForDt')->name('get_all_for_dt');

    });
})->middleware('access.routeNeedsPermission:all_functions');

/*
Route::prefix('role')->group(function () {
    Route::get('/index', [\App\Http\Controllers\Backend\Access\RoleController::class, 'index'])->name('backend.role.index');
    Route::get('/create', [\App\Http\Controllers\Backend\Access\RoleController::class, 'create'])->name('backend.role.create');
    Route::get('/edit/{role}', [\App\Http\Controllers\Backend\Access\RoleController::class, 'edit'])->name('backend.role.edit');
    Route::post('/store', [\App\Http\Controllers\Backend\Access\RoleController::class, 'store'])->name('backend.role.store');
    Route::put('/update/{role}', [\App\Http\Controllers\Backend\Access\RoleController::class, 'update'])->name('backend.role.update');
    Route::get('/profile/{role}', [\App\Http\Controllers\Backend\Access\RoleController::class, 'profile'])->name('backend.role.profile');
    Route::delete('/delete/{role}', [\App\Http\Controllers\Backend\Access\RoleController::class, 'delete'])->name('backend.role.delete');
    Route::get('/get_all_for_dt', [\App\Http\Controllers\Backend\Access\RoleController::class, 'getAllForDt'])->name('backend.role.get_all_for_dt');
    Route::get('/roles/users/{role}', [\App\Http\Controllers\Backend\Access\RoleController::class, 'users'])->name('backend.role.users');
});
*/
