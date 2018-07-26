<?php

use Illuminate\Support\Facades\Log;

Route::group(['middleware' => ['auth']], function () {
  /* 全体管理画面 */
  Route::get('/', 'DashboardController@index')->name('home');
  Route::get('/corpus', 'CorpusController@index')->name('corpus');
  Route::post('/corpus/create', 'CorpusController@createCorpus');
  Route::post('/corpus/delete', 'CorpusController@deleteCorpus');
  Route::post('/corpus/edit/{corpus_id}', 'CorpusController@editCorpus');

  Route::get('/api-info', 'ApiInfoController@index')->name('api-info');

  /* CMS */
  // Route::match(['get', 'post'], '/corpus/view/1', function() {
  //   return view('corpus-admin.ca-detail');
  // });

  /**コーパス管理画面 */
  Route::get('/corpus/view/{corpus_id}', 'CorpusController@corpusView');

  /** コーパス管理画面 データ管理 */
  Route::get('/corpus/data/view/{corpus_id}', 'CorpusController@corpusDataView');
  Route::post('/corpus/data/create/{corpus_id}', 'CorpusController@createCreative');
  Route::post('/corpus/data/edit/{corpus_id}', 'CorpusController@editCreative');
  Route::post('/corpus/data/delete/{corpus_id}', 'CorpusController@deleteCreative');
  Route::get('/corpus/csv/download/{corpus_id}', 'CorpusController@trainingDataDownload');
  // Route::post('/corpus/data/csv/upload/training/{corpus_id}', 'CorpusController@trainingDataUplocad');
  // Route::post('/corpus/data/csv/upload/test/{corpus_id}', 'CorpusController@testDataUplocad');
  Route::post('/corpus/data/csv/upload/{corpus_id}/{data_type}', 'CorpusController@trainingDataUplocad');

  /** コーパス管理画面 学習管理 */  
  Route::get('/corpus/training/{corpus_id}', 'TrainingManagerController@index');
  Route::get('/corpus/training/exec/{corpus_id}', 'TrainingManagerController@execTraining');
  Route::get('/corpus/training/check/{corpus_id}', 'TrainingManagerController@chechTrainingStatus');
  Route::post('/corpus/training/activate/{corpus_id}', 'TrainingManagerController@activateCorpus');
  Route::post('/settings/user/delete', 'ServiceController@deleteUser');

  // サービス管理
  Route::get('/settings', 'ServiceController@index');
  // Route::post('/settings/user/create', 'Auth\RegisterController@register');
  Route::post('/settings/user/register', 'ServiceController@registerUser');
  Route::post('/settings/user/edit', 'ServiceController@editUser');
  Route::post('/settings/user/delete', 'ServiceController@deleteUser');
  // Route::post('/settings/user/register', function() {
  //   echo 'test';
  // });

  /** 管理者機能：DBリフレッシュ */
  // Route::group(['middleware' => 'auth.very_basic', 'prefix' => ''], function() {
  //   Route::get('/dbrefresh', 'DashboardController@migrateRefresh');
  // });

});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );


/********************************
 * Auth::routes(); の中身
 *******************************/
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