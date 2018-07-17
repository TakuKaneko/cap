<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

use Illuminate\Http\Request;

Route::get('/cap', "ApiController@getCapResult");
Route::get('/list/{company_id?}', "ApiController@getApiList");


// Route::get('/color', function (){
    // $colors = array(
    //     'colors'=>
    //         array('id'=>1, 'fruit'=>'apple1', 'color'=>'red1'),
    //         array('id'=>2, 'fruit'=>'apple2', 'color'=>'red2'),
    //         array('id'=>3, 'fruit'=>'apple3', 'color'=>'red3')
    // );
    // return $colors;
    // return $request->header;    
// });

// Route::middleware('auth:api')->get('/test', function (Request $request) {
//     $colors = array(
//         'colors'=>
//             array('id'=>1, 'fruit'=>'apple1', 'color'=>'red1'),
//             array('id'=>2, 'fruit'=>'apple2', 'color'=>'red2'),
//             array('id'=>3, 'fruit'=>'apple3', 'color'=>'red3')
//     );
//     return $colors;
// });

// Route::group(['middleware' => 'api'], function() {
//     // Route::post('authenticate', 'AuthenticateController@authenticate');
//     Route::get('corpus', 'Dashboard\CorpusManagementController@index');
//     Route::get('colors',  function() {
//         $colors = array(
//             'colors'=>
//                 array('id'=>1, 'fruit'=>'apple1', 'color'=>'red1'),
//                 array('id'=>2, 'fruit'=>'apple2', 'color'=>'red2'),
//                 array('id'=>3, 'fruit'=>'apple3', 'color'=>'red3')
//         );
//         return $colors;
//     });
// });