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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('queue', 'Api\QueueController@addQueue');
    Route::get('employee', 'Api\EmployeeController@getEmployee');
    Route::post('employee', 'Api\EmployeeController@addEmployee');
    Route::put('employee', 'Api\EmployeeController@editEmployee');
});
