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

Route::group(['prefix' => 'v1', 'middleware' => ['cors']], function () {
  Route::post('queue', 'Api\QueueController@addQueue');
  Route::get('queue/petugas', 'Api\QueueController@getQueueForPetugas');
  Route::post('queue/petugas/next/{layananId}', 'Api\QueueController@takeLatestQueueFromAService');
  Route::post('queue/petugas/skip/{layananId}', 'Api\QueueController@skipLatestQueueFromAService');

  Route::get('employee', 'Api\EmployeeController@getEmployee');
  Route::post('employee', 'Api\EmployeeController@addEmployee');
  Route::put('employee', 'Api\EmployeeController@editEmployee');
  Route::delete('employee', 'Api\EmployeeController@deleteEmployee');

  Route::get('service', 'Api\ServiceController@getService');
  Route::post('service', 'Api\ServiceController@addService');
  Route::put('service', 'Api\ServiceController@editService');
  Route::delete('service', 'Api\ServiceController@deleteService');
  Route::put('service/change-status', 'Api\ServiceController@changeStatusService');

  Route::get('counter', 'Api\CounterController@getAllCounter');
  Route::post('counter', 'Api\CounterController@addCounter');
  Route::delete('counter', 'Api\CounterController@deleteCounter');
  Route::post('counter/reset/all', 'Api\CounterController@resetAllCounter');
  Route::post('counter/reset', 'Api\CounterController@resetSingleCounter');
});
