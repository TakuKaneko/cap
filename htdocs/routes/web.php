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

Route::get('/', 'DashboardController@index')->name('home');
Route::get('/corpus', 'CorpusController@index')->name('corpus');
Route::get('/api-info', 'ApiInfoController@index')->name('api-info');

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


/* CMS */
Route::match(['get', 'post'], '/corpus/view/1', function() {
  return view('corpus-admin.ca-detail');
});

Route::get('/corpus/data/view/{id}', function($id) {
  return view('corpus-admin.ca-data-view', ['corpus_id' => $id]);
});

Route::get('/corpus/csv/download/{id}', 'CorpusController@trainingDataDownload');
Route::post('/corpus/csv/upload/{corpus_id}/{type}', 'CorpusController@trainingDataUplocad');

Route::get('/corpus/training', function() {
  return view('corpus-admin.ca-training');
});


Route::get('/settings', function() {
  Log::info("アクセスsaretayo.");
  return view('dashboard.settings');
});

Auth::routes();
/*
  // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('logout');

  // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    $this->post('register', 'Auth\RegisterController@register');

  // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
*/

Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );