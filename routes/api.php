<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UsersController;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'auth'])->name('login');
    Route::post('signup', [AuthController::class, 'signup']);

    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('users', [AuthController::class, 'getUsers']);
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function() {
        Route::get('/user-details', [UsersController::class, 'getUserDetails']);
        Route::post('/user-details', [UsersController::class, 'addUserDetails']);
    });
}); 