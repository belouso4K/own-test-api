<?php

//No routes in here!
use App\Http\Controllers\Auth\AuthController;
Route::group(['middleware' => 'guest'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/db', function () {
    return 'wqfqssesf213';
});
