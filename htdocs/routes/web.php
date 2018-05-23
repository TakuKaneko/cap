<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register weßb routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Log;

Route::get('/', function() {
  return view('dashboard.top');
});

Route::get('/acount', function() {
  return view('dashboard.acount-list');
});

Route::post('/acount', function() {
  return redirect('acount')->with('msg', __('編集が完了しました。'));
  // return view('acount-list');
});

Route::get('/acount/edit/1', function() {
  return view('dashboard.acount-edit');
});

Route::post('/acount/confirm/1', function() {
  return view('dashboard.acount-confirm');
});

Route::get('/corpus', function() {
  return view('dashboard.corpus');
});

Route::match(['get', 'post'], '/corpus/view/1', function() {
  return view('corpus-admin.ca-detail');
});

Route::get('/corpus/data/view/1', function() {
  return view('corpus-admin.ca-data-view');
});

Route::get('/corpus/training', function() {
  return view('corpus-admin.ca-training');
});

Route::get('/api-info', function() {
  return view('dashboard.api-info');
});

Route::get('/settings', function() {

  Log::info("アクセスsaretayo.");
  return view('dashboard.settings');
});