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
    'prefix' => 'deposit'
], function () {
    // Custom route
    Route::get('history', 'DepositController@getHistory')->name('deposit.history');
    
    // Resource route
    Route::post('/', 'DepositController@postCreate')->name('deposit.store');
    Route::get('{deposit}', 'DepositController@show')->name('deposit.show');
    Route::patch('{deposit}', 'DepositController@update')->name('deposit.update');
    Route::delete('{deposit}', 'DepositController@destroy')->name('deposit.destroy');
});