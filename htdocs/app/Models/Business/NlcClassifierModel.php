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
            $this->setStatus($classifier_id);
        }
    }

    /**
     * NLC の生成
     */
    public function createNlc($data)
    {
        // 教師データを元にNLCを作成

        $this->nlc_url = "https://gateway.watson-j.jp/natural-language-classifier/api/v1/classifiers/";
        $this->classifier_id = "28680bx78-nlc-1988";
        $this->status = "Available";

        return $this;
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
    public function setStatus($classifier_id)
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
        if ($this->status == "Available")
        {
            return true;
        }
        return false;
    }

    /**
     * NLC に対するクエリが正常化であれば true を返す
     */
    public function isQueryCorrect($text)
    {
        $text_length = mb_strlen($text, 'UTF-8');
        if ($text_length < 1024)
        {
            return true;
        }
        return false;
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


        // 閾値以上のクラス
        $nlc_result_array = array(); // クラス名と確信度を部分抽出した配列
        foreach ($nlc_res['classes'] as $key => $value)
        {
            $nlc_result_array[$value['class_name']] = $value['confidence'];
        }

        $target_corpus = Api::where('display_api_id', 'like', $display_api_id)->first()->corpuses->first();
        $target_classes = $target_corpus->corpusClasses;

        $class_threshold_array = array();
        foreach ($target_classes as $class)
        {
            $class_threshold_array[$class->name] = $class->threshold;
        }

        $passed_classes_array = array();
        $ca_results_array = array(); // results格納用
        $cnt = 0;
        foreach ($nlc_result_array as $key => $value)
        {
            $ca_results_array[$cnt]['class_name'] = $key;
            $ca_results_array[$cnt]['confidence'] = $value;
            if (array_key_exists($key, $class_threshold_array)) {
                $ca_results_array[$cnt]['threshold'] = $class_threshold_array[$key];
                if ($value >= $class_threshold_array[$key]) {
                    $ca_results_array[$cnt]['result'] = 1;
                    $passed_classes_array[] = $key;
                } else {
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