<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('home', ['type' => ['A', 'B', 'C', 'D', 'E', 'F']]);
});

Route::get('admin/login', 'AdminController@showLogin');
Route::post('admin/login', 'AdminController@login');
Route::group(['prefix' => 'admin', 'middleware' => ['isAdminLoggedIn']], function () {
  Route::get('/', 'AdminController@index');
  Route::get('/logout', 'AdminController@logout');
  Route::get('/pegawai', function () {
  	return view('admin/data_petugas');
  });
});
