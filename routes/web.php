<?php

use Illuminate\Support\Facades\Route;
use glasswalllab\keypayconnector\Http\Controllers\AuthController;

Route::group(['middleware' => ['web']], function () {
    Route::get('/keypay/signin', [AuthController::class, 'signin']);
    Route::get('/keypay/callback', [AuthController::class, 'callback']);
    Route::get('/keypay/signout/{provider}', [AuthController::class, 'signout']);
});
