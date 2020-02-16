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

Route::get('/', 'HomeController@showHome');

Route::get('admin/login', 'AdminController@showLogin');
Route::post('admin/login', 'AdminController@login');
Route::group(['prefix' => 'admin', 'middleware' => ['isAdminLoggedIn']], function () {
  Route::get('/', 'AdminController@index');
  Route::get('/logout', 'AdminController@logout');
  Route::get('/petugas', 'AdminController@showPetugas');
  Route::get('/layanan', 'AdminController@showLayanan');
  Route::get('/loket', 'AdminController@showLoket');
  Route::get('/display', 'AdminController@showDisplayAdmin');
  Route::post('/display', 'AdminController@updateDisplay');
  Route::get('/rekapan', 'AdminController@showRekapan');
});

Route::get('petugas/login', 'PetugasController@showLogin');
Route::post('petugas/login', 'PetugasController@login');
Route::group(['prefix' => 'petugas', 'middleware' => ['isPetugasLoggedIn']], function () {
  Route::get('/', 'PetugasController@index');
  Route::get('/loket', 'PetugasController@allCounter');
  Route::get('/loket/keluar', 'PetugasController@exitCounter');
  Route::get('/loket/{id}', 'PetugasController@counter');
  Route::get('/loket/ambil/{id}', 'PetugasController@takeCounter');
  Route::get('/loket/{id}/kepuasan', 'PetugasController@showKepuasan');
  Route::get('/logout', 'PetugasController@logout');
});

Route::get('/display', 'HomeController@showDisplay');
Route::get('/print', function(){
  return view('print');
});
