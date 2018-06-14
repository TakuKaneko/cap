<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| 本システムはSPAで構築されているため、View生成はVue.jsが担当する。
| Laravel側ではすべてのWebルートに対して、app.blade.php を返すだけでよい。
|
*/
use Illuminate\Support\Facades\Log;

Route::get('/{any}', function () {
  return view('app');
})->where('any', '.*');