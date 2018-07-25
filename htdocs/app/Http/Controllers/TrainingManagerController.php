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

use Log; // 追加
use Validator;
use Carbon\Carbon;

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
            $training_data_status = TrainingDataStatus::getDescription('1');

        } else if(5 > $training_data_count || $training_data_count > 15000) {
            $training_data_status = TrainingDataStatus::getDescription('2');

        } else {
            if($untraining_data_count > 0) {
                $training_data_status = TrainingDataStatus::getDescription('3');
            } else {
                $training_data_status = TrainingDataStatus::getDescription('4');
            }
        }
        
        // 学習可能かどうか
        $can_training = false;
        if($training_data_status == TrainingDataStatus::getDescription('3')) {
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
            // $my_classifier_api = Api::where('company_id', $my_company_id)->first();

            $set_nlc_url = $my_company->nlc_url;
            $set_nlc_username = $my_company->nlc_username;
            $set_nlc_password = $my_company->nlc_password;
            // $set_classifier_id = $my_classifier_api->nlc_id;
            $set_classifier_id = $target_corpus->tmp_nlc_id;

            $this->logInfo('[nlc_url] ' . $set_nlc_url);
            $this->logInfo('[username] ' . $set_nlc_username);
            $this->logInfo('[password] ' . $set_nlc_password);
            $this->logInfo('[classifier_id] ' . $set_classifier_id);
            
            $nlc_classifier = new NlcClassifierModel($set_nlc_url, $set_nlc_username, $set_nlc_password, $set_classifier_id);


            // すでにnlc_idがあれば削除
            if($nlc_classifier->getClassifierId()) {
                // NLC削除
                $this->logInfo('nlcを削除します');
                $nlc_classifier = $nlc_classifier->deleteNlc();

                $error_msg = $nlc_classifier->getErrorMessage();
                $this->logInfo($error_msg);
                if(!empty($error_msg)) {
                    throw new \Exception($error_msg);
                }

                // apisテーブルのnlc_idをからに
                $target_corpus->tmp_nlc_id = "";
                $target_corpus->save();
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
            // $api = Api::find($my_classifier_api->id);
            // $api->nlc_id = $new_nlc->getClassifierId();
            // $api->save();
            $target_corpus->tmp_nlc_id = $new_nlc->getClassifierId();
            $target_corpus->save();

            // コーパスのステータスを学習中に変更してnlc生成実行
            $target_corpus->status = CorpusStateType::Training;
            $target_corpus->save();


            DB::commit();            


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
     * コーパスの本番反映
     * @param String $corpus_id
     */
    public function avtivateCorpus($corpus_id) 
    {
        // 指定コーパスの仮nlc_idを取得
        $corpus = Corpus::find($corpus_id);
        $tmp_nlc_id = $corpus->tmp_nlc_id;

        // 指定コーパスに紐づくAPIレコード取得
        $target_api = $corpus->apis->first();

        // APIテーブル更新
        DB::beginTransaction();
        try 
        {
            $target_api->nlc_id = $tmp_nlc_id;
            $target_api->save();
            DB::commit();
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
        return redirect('/corpus/training/' . $corpus_id)->with('msg', '本番反映が完了しました。');
    }

    /**
     * 訓練ステータスチェック
     */
    public function chechTrainingStatus($corpus_id) {
        // レスポンス形式
        $res = array(
            'result' => true,
            'data' => array(
                'corpus_status' => ''
            ),
            'error' => array(
                'message' => ''
            )
        );

        // nlcのチェックステータス
        $nlc_training_status = 'Training';
        $nlc_complate_status = 'Available';

        // 認証チェック
        $user = Auth::user();
        if($user === null) {
            $res['result'] = false;
            $res['error']['message'] = '認証に失敗しました';
        }

        // コーパスidがユーザの企業に所属しているか
        $target_corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->first();
        if(count($target_corpus)  === 0) {
            $res['result'] = false;
            $res['error']['message'] = '不正なパラメータです';
        }

        
        // コーパスのステータスがトレーニング中であればステータスチェック実施
        if((int)$target_corpus->status !== CorpusStateType::Training) {
            // それ以外のステータスはスキップ
            LOG::info('[chechTrainingStatus] トレーニングステータス以外がセットされています');
            LOG::info('[chechTrainingStatus] ' . $target_corpus->status);

        } else {

            DB::beginTransaction();
            LOG::info('[chechTrainingStatus] トランザクションを開始します');

            try {
                // nlcインスタンスを生成
                $my_company = Company::find($user->company_id);

                $set_nlc_url = $my_company->nlc_url;
                $set_username = $my_company->nlc_username;
                $set_password = $my_company->nlc_password;
                $set_classifier_id = $target_corpus->tmp_nlc_id;

                LOG::info('[chechTrainingStatus] NLCインスタンスを生成します');
                $nlc = new NlcClassifierModel($set_nlc_url, $set_username, $set_password, $set_classifier_id);



                // ステータス確認してレスポンスにセット
                $nlc_current_status = $nlc->getStatus();
                LOG::info('[chechTrainingStatus] 現在のNLCステータス: ' . $nlc_current_status);

                $res['data']['nlc_current_status'] = $nlc_current_status;

                if($nlc_current_status === $nlc_complate_status) {
                    LOG::info('[chechTrainingStatus] NLCの学習は完了しています');

                    // コーパスのステータスを更新
                    $target_corpus->status = CorpusStateType::StandBy;
                    $target_corpus->save();


                    // 未学習データの学習完了日をセット
                    LOG::info('[chechTrainingStatus] 学習完了日をセットします');

                    $related_class_id = CorpusClass::where('corpus_id', $corpus_id)->get(['id']);

                    // 100件ずつ取り出して更新
                    $related_creatives = CorpusCreative::whereIn('corpus_class_id', $related_class_id)
                        ->where('data_type', CorpusDataType::Training)
                        ->chunk(100, function ($creatives) {
                            
                            $now = Carbon::now();

                            foreach($creatives as $creative) {
                                $creative->training_done_data = $now;
                                $creative->save();
                            }
                        }
                    );

                } else {
                    LOG::info('[chechTrainingStatus] NLCの学習は完了していません');
                } 

                DB::commit();


            } catch(\PDOException $e) {
                DB::rollBack();

                $res['result'] = false;
                $res['error']['message'] = 'データベースの更新に失敗しました';

                return json_encode($res);
            }

        }

        // 現在のコーパスステータス返却
        $res['data']['corpus_status'] = $target_corpus->status;
        return json_encode($res);
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
