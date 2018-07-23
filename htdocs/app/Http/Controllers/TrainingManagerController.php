<?php

/*
 * This file is part of the CAP service.
 *
 * Copyright © <1218> PASONATECH.CO., LTD. All rights reserved.
 * 
 * This source code or any portion thereof must not be
 * reproduced or used in any manner whatsoever.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Corpus;
use App\Models\CorpusClass;
use App\Models\CorpusCreative;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;          // DBのトランザクション利用
use Validator;

// use App\Enums\CorpusStateType;
// use App\Enums\CorpusDataType;
// use App\Enums\CorpusType;
// use App\Enums\ClassifierLanguage;

class TrainingManagerController extends Controller
{
    // 学習管理画面の表示
    public function index($corpus_id) {

        // 認証チェック
        $user = Auth::user();
        if($user === null) {
            return redirect('login'); // ログアウト
        }
    
        // コーパス情報取得
        $corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->first();

        return view('corpus-admin.ca-training', ['corpus' => $corpus]);
    }

    

    /**
     * 開発ログ確認用
     */
    private $debug = false;
    private function logInfo($msg) {
      if($this->debug) {
        var_dump($msg);
        echo '<br>';
      }
        
    }

}
