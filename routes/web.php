<?php

use Illuminate\Support\Facades\Route;
use glasswalllab\keypayconnector\Http\Controllers\AuthController;

Route::group(['middleware' => ['web']], function () {
    Route::get('/signin', [AuthController::class, 'signin']);
    Route::get('/callback', [AuthController::class, 'callback']);
    Route::get('/signout/{provider}', [AuthController::class, 'signout']);
});
