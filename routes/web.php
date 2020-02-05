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
  return view('home', ['API_KEY' => env("API_KEY"), 'type' => ['A', 'B', 'C', 'D', 'E', 'F']]);
});

Route::get('admin/login', 'AdminController@showLogin');
Route::post('admin/login', 'AdminController@login');
Route::group(['prefix' => 'admin', 'middleware' => ['isAdminLoggedIn']], function () {
  Route::get('/', 'AdminController@index');
  Route::get('/logout', 'AdminController@logout');
  Route::get('/petugas', 'AdminController@showPetugas');
  Route::get('/layanan', 'AdminController@showLayanan');
  Route::get('/loket', 'AdminController@showLoket');
});

Route::get('petugas/login', 'PetugasController@showLogin');
Route::post('petugas/login', 'PetugasController@login');
Route::group(['prefix' => 'petugas', 'middleware' => ['isPetugasLoggedIn']], function () {
  Route::get('/', 'PetugasController@index');
  Route::get('/logout', 'PetugasController@logout');
  Route::get('/{id}', 'PetugasController@ambilLoket');
});

Route::get('/lokets', function () {
  return view('loket/loket');
});
