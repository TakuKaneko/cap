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

Route::group(['middleware' => 'api'], function() {
    Route::post('authenticate', 'AuthenticateController@authenticate');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('colors',  function() {
            $colors = array(
                'colors'=>
                    array('id'=>1, 'fruit'=>'apple1', 'color'=>'red1'),
                    array('id'=>2, 'fruit'=>'apple2', 'color'=>'red2'),
                    array('id'=>3, 'fruit'=>'apple3', 'color'=>'red3')
            );
            return $colors;
        });

        Route::get('me', 'AuthenticateController@getCurrentUser');

    });    
});