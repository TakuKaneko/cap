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

Route::get('/', function() {
  return view('dashboard');
});

Route::get('/acount', function() {
  return view('acount-list');
});

Route::post('/acount', function() {
  return view('acount-list', ['msg' => '編集が完了しました。']);
});

Route::get('/acount/edit/1', function() {
  return view('acount-edit');
});

Route::post('/acount/confirm/1', function() {
  return view('acount-confirm');
});