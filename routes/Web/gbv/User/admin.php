<?php
Route::prefix('users')->middleware('access.routeNeedsPermission:all_functions')->group(function () {
    Route::get('/user', [\App\Http\Controllers\Gbv\UserCrudController::class, 'index'])->name('backend.user');
    Route::get('/get-all-users', [\App\Http\Controllers\Gbv\UserCrudController::class, 'fetchUser'])->name('backend.get.user');
    Route::get('/get-admin-users', [\App\Http\Controllers\Gbv\UserCrudController::class, 'fetchAdminUser'])->name('backend.get.admin.user');

    Route::get('/create_user', [\App\Http\Controllers\Gbv\UserCrudController::class, 'create'])->name('backend.create_user');
    Route::post('/create', [\App\Http\Controllers\Gbv\UserCrudController::class, 'store'])->name('backend.create.user');
    Route::post('/update/{user}', [\App\Http\Controllers\Gbv\UserCrudController::class, 'update'])->name('backend.update.user');
    Route::post('/delete-user/{user}', [\App\Http\Controllers\Gbv\UserCrudController::class, 'deleteUser'])->name('backend.delete.user');

    Route::get('/show/{user}', [\App\Http\Controllers\Gbv\UserCrudController::class, 'profile'])->name('backend.show.user');
    Route::get('/edit/{user}', [\App\Http\Controllers\Gbv\UserCrudController::class, 'edit'])->name('backend.edit.user');
    Route::get('/activity/{user}', [\App\Http\Controllers\Gbv\UserCrudController::class, 'activity'])->name('backend.user.activity');

});
