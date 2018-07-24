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
use Illuminate\Support\Facades\Artisan;

use App\Jobs\CheckNlcTrainingStatus;

use App\Models\Company;
use App\Models\Api;
use App\Models\Corpus;
use App\Models\CorpusClass;
use App\Models\CorpusCreative;
use App\Http\Controllers\Controller;
use App\Models\Business\TrainingDataModel;
use App\Models\Business\NlcClassifierModel;
use Illuminate\Support\Facades\DB;          // DBのトランザクション利用
use Validator;

use App\Enums\CorpusStateType;
use App\Enums\CorpusDataType;
// use App\Enums\CorpusType;
use App\Enums\ClassifierLanguage;
use App\Enums\TrainingDataStatus;


class TrainingManagerController extends Controller
{
    /**
     * 学習管理画面の表示
     */
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
     * 学習実行
     */
    public function execTraining($corpus_id) {
        // 認証チェック
        $user = Auth::user();
        if($user === null) {
            return redirect('login'); // ログアウト
        }


        $this->logInfo('[corpus_id: ' . $corpus_id . '] 学習を開始します');

        // 登録処理
        DB::beginTransaction();

        try{

            // コーパスの存在確認
            $corpus_count = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->count();
            if($corpus_count === 0) {
                throw new \Exception('不正なパラメータです');
            }

            $target_corpus = Corpus::find($corpus_id);


            // 学習データモデル生成
            $training_data = new TrainingDataModel($corpus_id);
            // CSV保存
            $training_data->saveTrainingDataCsv();

            // CSV保存結果を確認
            $error_msg = $training_data->getErrorMessage();
            if(!empty($error_msg)) {
                throw new \Exception($error_msg);
            }
            $this->logInfo('CSV保存完了');


            // CSVファイルパスを取得してトレーニングデータモデルのインスタンス生成
            $this->logInfo('NLC Classifierモデルインスタンス生成');

            $my_company_id = $user->company_id;
            $my_company = Company::find($my_company_id);
            $my_classifier_api = Api::where('company_id', $my_company_id)->first();

            $set_nlc_url = $my_company->nlc_url;
            $set_nlc_username = $my_company->nlc_username;
            $set_nlc_password = $my_company->nlc_password;
            $set_classifier_id = $my_classifier_api->nlc_id;

            $this->logInfo('[nlc_url] ' . $set_nlc_url);
            $this->logInfo('[username] ' . $set_nlc_username);
            $this->logInfo('[password] ' . $set_nlc_password);
            $this->logInfo('[classifier_id] ' . $set_classifier_id);
            
            $nlc_classifier = new NlcClassifierModel($set_nlc_url, $set_nlc_username, $set_nlc_password, $set_classifier_id);


            // すでにnlc_idがあれば削除
            if($nlc_classifier->getClassifierId()) {
                // NLC削除
                $nlc_classifier->deleteNlc();

                $error_msg = $training_data->getErrorMessage();
                if(!empty($error_msg)) {
                    throw new \Exception($error_msg);
                }

                // apisテーブルのnlc_idをからに
                $api = Api::find($my_classifier_api->id);
                $api->nlc_id = "";
                $api->save();
            }


            $this->logInfo('[NLC用CSVパス]' . $training_data->getTrainingDataPath());

            // nlc生成
            $cfile = new \CURLFile($training_data->getTrainingDataPath());
            $data = array(
                "training_data" => $cfile,
                "training_metadata" => "{\"language\":\"" . ClassifierLanguage::getDescription($target_corpus->language) . "\",\"name\":\"" . $target_corpus->name . "\"}"
            );

            $new_nlc = $nlc_classifier->createNlc($data);

            $error_msg = $new_nlc->getErrorMessage();
            if(!empty($error_msg)) {
                throw new \Exception($error_msg);
            }

            // 新しいnlc_idを設定
            $api = Api::find($my_classifier_api->id);
            $api->nlc_id = $new_nlc->getClassifierId();
            $api->save();

            // コーパスのステータスを学習中に変更してnlc生成実行
            $target_corpus->status = CorpusStateType::Training;
            $target_corpus->save();


            DB::commit();


            // job
            $job = (new CheckNlcTrainingStatus($corpus_id, $set_nlc_url, $set_nlc_username, $set_nlc_password, $set_classifier_id));
            dispatch($job)->delay(now()->addMinutes(1));
            


        } catch (\PDOException $e){
            DB::rollBack();
            var_dump($e->getMessage());
            exit;
            return redirect('/corpus/training/' . $corpus_id)->with('error_msg', $e->getMessage());
    
        } catch(\Exception $e) {
            DB::rollBack();
            var_dump($e->getMessage());
            exit;
            return redirect('/corpus/training/' . $corpus_id)->with('error_msg', $e->getMessage());
        }

        $this->logInfo('正常に完了しました');
        return redirect('/corpus/training/' . $corpus_id)->with('msg', 'ただ今学習中です。');
    }



    /**
     * 開発ログ確認用
     */
    private $debug = true;
    private function logInfo($msg) {
      if($this->debug) {
        var_dump($msg);
        echo '<br>';
      }
        
    }

}
