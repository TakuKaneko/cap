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

Route::group(['middleware' => ['auth']], function () {
  /* 全体管理画面 */
  Route::get('/', 'DashboardController@index')->name('home');
  Route::get('/corpus', 'CorpusController@index')->name('corpus');
  Route::get('/api-info', 'ApiInfoController@index')->name('api-info');

  /* CMS */
  Route::match(['get', 'post'], '/corpus/view/1', function() {
    return view('corpus-admin.ca-detail');
  });

  /** コーパス管理画面 データ管理 */
  Route::get('/corpus/data/view/{corpus_id}', 'CorpusController@corpusDataView');
  Route::post('/corpus/data/create/{corpus_id}', 'CorpusController@createCreative');
  Route::post('/corpus/data/edit/{corpus_id}', 'CorpusController@editCreative');
  Route::post('/corpus/data/delete/{corpus_id}', 'CorpusController@deleteCreative');
  Route::get('/corpus/csv/download/{corpus_id}', 'CorpusController@trainingDataDownload');
  // Route::post('/corpus/csv/upload/{corpus_id}/{upload_data_type}', 'CorpusController@trainingDataUplocad');
  Route::post('/corpus/data/csv/upload/training/{corpus_id}', 'CorpusController@trainingDataUplocad');
  Route::post('/corpus/data/csv/upload/test/{corpus_id}', 'CorpusController@testDataUplocad');
  Route::get('/corpus/training', function() {
    return view('corpus-admin.ca-training');
  });
  Route::get('/settings', function() {
    Log::info("アクセスsaretayo.");
    return view('dashboard.settings');
  });
});

// Route::get('/acount', function() {
//   return view('dashboard.acount-list');
// });

// Route::post('/acount', function() {
//   return redirect('acount')->with('msg', __('編集が完了しました。'));
//   // return view('acount-list');
// });

// Route::get('/acount/edit/1', function() {
//   return view('dashboard.acount-edit');
// });

// Route::post('/acount/confirm/1', function() {
//   return view('dashboard.acount-confirm');
// });

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );

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