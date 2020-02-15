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
  Route::post('queue', 'API\QueueController@addQueue');
  Route::get('queue/petugas', 'API\QueueController@getQueueForEmployee');
  Route::get('queue/petugas/{petugasId}', 'API\QueueController@getCurrentQueueInALoket');
  Route::post('queue/petugas/next/{layananId}', 'API\QueueController@takeLatestQueueFromAService');
  Route::post('queue/petugas/skip/{layananId}', 'API\QueueController@skipLatestQueueFromAService');
  Route::post('queue/kepuasan', 'API\QueueController@updateKepuasanOfQueue');
  Route::post('queue/recall', 'API\QueueController@recall');

  Route::get('employee', 'API\EmployeeController@getEmployee');
  Route::post('employee', 'API\EmployeeController@addEmployee');
  Route::put('employee', 'API\EmployeeController@editEmployee');
  Route::delete('employee', 'API\EmployeeController@deleteEmployee');

  Route::get('service', 'API\ServiceController@getService');
  Route::post('service', 'API\ServiceController@addService');
  Route::put('service', 'API\ServiceController@editService');
  Route::delete('service', 'API\ServiceController@deleteService');
  Route::put('service/change-status', 'API\ServiceController@changeStatusService');

  Route::get('counter', 'API\CounterController@getAllCounter');
  Route::post('counter', 'API\CounterController@addCounter');
  Route::delete('counter', 'API\CounterController@deleteCounter');
  Route::post('counter/reset/all', 'API\CounterController@resetAllCounter');
  Route::post('counter/reset', 'API\CounterController@resetSingleCounter');
  Route::get('counter/active', 'API\CounterController@getActiveCounter');
});
