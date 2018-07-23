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
use App\Enums\CorpusDataType;
// use App\Enums\CorpusType;
// use App\Enums\ClassifierLanguage;
use App\Enums\TrainingDataStatus;


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

        // 該当のコーパスに登録されているクラスidを取得
        $corpus_class_id_list = CorpusClass::where('corpus_id', $corpus_id)->get(['id']);

        // 学習データ件数の取得
        $training_data_count = CorpusCreative::where('data_type', CorpusDataType::Training)
                                                ->whereIn('corpus_class_id', $corpus_class_id_list)
                                                ->count();

        // 未学習データ件数の取得
        $untraining_data_count = CorpusCreative::where('data_type', CorpusDataType::Training)
                                                ->where('training_done_data', null)
                                                ->whereIn('corpus_class_id', $corpus_class_id_list)
                                                ->count();

        // 学習データの状態
        $training_data_status;

        if($training_data_count == 0) {
            $training_data_status = TrainingDataStatus::NoData;

        } else if(5 > $training_data_count || $training_data_count > 15000) {
            $training_data_status = TrainingDataStatus::DataDeficiencies;

        } else {
            if($untraining_data_count > 0) {
                $training_data_status = TrainingDataStatus::ExistUntrainingData;

            } else {
                $training_data_status = TrainingDataStatus::NnUntrainingData;
            }
        }
        
        // 学習可能かどうか
        $can_training = false;
        if($training_data_status === TrainingDataStatus::ExistUntrainingData) {
            $can_training = true;
        }

        
        // 学習状況
        $training_status = array(
            'training_data_status' => $training_data_status,
            'can_training' => $can_training
        );

        return view('corpus-admin.ca-training', ['corpus' => $corpus, 'training_status' => $training_status]);
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
