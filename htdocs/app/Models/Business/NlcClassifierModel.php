<?php

namespace App\Models\Business;

use App\Models\Api;
use App\Models\CorpusClass;


/**
 * Watson NLC への接続処理の実装を担当するモデル
 */
class NlcClassifierModel
{
    protected $nlc_url; 
    protected $username;
    protected $password;
    protected $classifier_id;  // NLC classfier-id
    protected $status; // NLCのステータス（0:avairable, 1:training, 9:unavairable）
    protected $err_msg; // エラーメッセージ
    
    /**
     * コンストラクタ
     * @param NLCのアクセスURL, UserName, Password, classifierID
     * NLCを生成し、statusに結果をセット
     */
    public function __construct($nlc_url, $username, $password, $classifier_id = NULL)
    {
        $this->nlc_url = $nlc_url;
        $this->username = $username;
        $this->password = $password;
        if ($classifier_id) 
        {
            $this->classifier_id = $classifier_id;

            // status をNLCから取得しプロパティにセット
            $this->setStatus();
        }
    }


    /**
     * エラーメッセージを返す
     */
    public function getErrorMessage() {
        return $this->err_msg;
    }


    /**
     * NLC の削除
     */
    public function deleteNlc() {

        if ($this->username && $this->password && $this->nlc_url && $this->classifier_id) {
            // curl の実行
            try {
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $this->nlc_url . $this->classifier_id);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 証明書の検証を行わない
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

                $result = curl_exec($curl);
                $result_json = json_decode($result, true);
                curl_close($curl);

                // エラー処理
                if( array_key_exists('code', $result_json) && ($result_json['code'] !== 200) ) {
                    throw new \Exception($result_json['error'] . ': ' . $result_json['description']);
                }

                $this->classifier_id = NULL;
                $this->err_msg = "";

                return;

            } 
            catch (\Exception $e)
            {
                $this->err_msg = $e->getMessage();
                return;
            }

        } 

        // プロパティがセットされていない場合、エラーセット
        $this->err_msg = $e->getMessage();
        return;
    }


    /**
     * NLC の生成
     */
    public function createNlc($data)
    {
        // 教師データを元にNLCを作成
        // nlcのapiをcurlでたたく
        try {
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $this->nlc_url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 証明書の検証を行わない
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す
            // post設定
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    
            $result = curl_exec($curl);
            $result_json = json_decode($result, true);
            curl_close($curl);

            // エラー処理
            if( array_key_exists('code', $result_json) && ($result_json['code'] !== 200) ) {
                throw new \Exception($result_json['error'] . ': ' . $result_json['description']);
            }

            if($result_json['status'] !== 'Training') {
                throw new \Exception('学習に失敗しました');
            }


            $this->status = $result_json['status'];
            $this->classifier_id = $result_json['classifier_id'];

            // // 3分ごとにnlcのapiで学習ステータスを確認する
            // $break_status = 'Available';
            // $sleep_time = 60 * 3;

            // while($this->getStatus() !== $break_status) {
            //     sleep($sleep_time);
            //     $this->setStatus($this->classifier_id);
            // }

            return $this;
            

        } catch (\Exception $e) {
            $this->err_msg = $e->getMessage();
            // var_dump('[error] '. $this->err_msg);exit;
        }
    }

    /**
     * NLC の実行
     */
    public function runClassify($text)
    {
        // クリエイティブのバリデーション実施
        // $res = $this->creativeValidation($creative);

        // テキスト分類のcurl実行
        try {
            $query_param = "/classify?text=" . rawurlencode($text);
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $this->nlc_url . $this->classifier_id . $query_param);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 証明書の検証を行わない
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

            $result = curl_exec($curl);
            $result_json = json_decode($result, true);
            curl_close($curl);

            // status をセット
            $this->status = "Avairable";
            
            return $result_json;
        } 
        catch (\Exception $e)
        {
            $this->status = "error: curl exec exception.";
            echo "exception";exit;
            return;
        }

    }

    /**
     * NLC の現在のステータスをプロパティにセット
     */
    public function setStatus()
    {
        if ($this->username && $this->password && $this->nlc_url && $this->classifier_id)
        {
            // curl の実行
            try {
                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, $this->nlc_url . $this->classifier_id);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
                curl_setopt($curl, CURLOPT_USERPWD, $this->username . ":" . $this->password);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 証明書の検証を行わない
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 証明書の検証を行わない
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // curl_execの結果を文字列で返す

                $result = curl_exec($curl);
                $result_json = json_decode($result, true);
                curl_close($curl);

                // status をセット
                $this->status = $result_json["status"];
                return;
            } 
            catch (\Exception $e)
            {
                $this->status = "error: curl exec exception.";
                return;
            }
        }

        // プロパティがセットされていない場合、エラーステータスをセット
        $this->status = "error: Illegal property.";

    }

    /**
     * NLC の現在のステータスを返す
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * NLC の現在のステータスが「Avairable」であれば true を返す
     */
    public function isAvairable()
    {
        // $this->setStatus();
        if ($this->status == "Available")
        {
            return true;
        }
        return false;
    }

    /**
     * NLC に対するクエリが正常であれば true を返す
     */
    public function isQueryCorrect($text)
    {
        // textの文字数チェック
        $text_length_flg = mb_strlen($text, 'UTF-8') < 1024 ? true : false;

        return $text_length_flg;
    }

    /**
     * NLC の実行結果を CAP のレスポンス形式にして加工して返す
     */
    public function runCognitiveAdCheck($display_api_id, $text)
    {
        /* NLC の実行結果を取得 */
        $nlc_res = $this->runClassify($text);

        $ca_res_array = array();

        // API-ID
        $ca_res_array['api_id'] = $display_api_id;
        // API-URL
        $ca_res_array['url'] = config('app.api_exec_url') . $display_api_id;
        // 審査対象テキスト
        $ca_res_array['text'] =  $text;
        // 閾値以上のクラス
        $nlc_result_array = array(); // NLC実行結果から取得したクラス名と確信度を格納する配列
        foreach ($nlc_res['classes'] as $key => $value)
        {
            $nlc_result_array[$value['class_name']] = $value['confidence'];
        }

        $target_corpus = Api::where('display_api_id', 'like', $display_api_id)->first()->corpuses->first();
        $target_classes = $target_corpus->corpusClasses;

        $class_threshold_array = array(); // コーパスクラスTBLに保存された各クラスの名前と閾値を格納する配列
        foreach ($target_classes as $class)
        {
            $class_threshold_array[$class->name] = $class->threshold;
        }

        $passed_classes_array = array();
        $ca_results_array = array(); // APIレスポンスの[results]値格納用の配列
        $cnt = 0;
        foreach ($nlc_result_array as $key => $value)
        {
            $ca_results_array[$cnt]['class_name'] = $key;
            $ca_results_array[$cnt]['confidence'] = $value;
            if (array_key_exists($key, $class_threshold_array)) 
            {
                $ca_results_array[$cnt]['threshold'] = $class_threshold_array[$key];
                if ($value >= $class_threshold_array[$key]) 
                {
                    $ca_results_array[$cnt]['result'] = 1;
                    $passed_classes_array[] = $key;
                } 
                else 
                {
                    $ca_results_array[$cnt]['result'] = 0;
                }
            } else {
                $ca_results_array[$cnt]['threshold'] = "";
                $ca_results_array[$cnt]['result'] = "";
            }    
            $cnt++;
        }
        $ca_res_array['passed_classes'] = $passed_classes_array;

        // results の内容
        $ca_res_array['results'] = $ca_results_array;

        return json_encode($ca_res_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * NLCのClassifier_idを取得
     */
    public function getClassifierId() {
        return $this->classifier_id;
    }

}