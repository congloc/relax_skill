<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('me', 'AuthController@me');
    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
    Route::post('register', 'AuthController@register');
    Route::get('verify-email', 'AuthController@verify_email');
    Route::post('verify-code', 'AuthController@verify_code');
    Route::post('send-code-forgot-password', 'AuthController@sendCodeForgotPassword');
    Route::post('send-code-reset-password', 'AuthController@sendCodeResetPassword');
    Route::post('check-code', 'AuthController@checkCode');
    Route::post('update-password', 'AuthController@updatePassword');
});
