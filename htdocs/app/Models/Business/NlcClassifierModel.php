<?php

namespace App\Models\Business;

/**
 * Watson NLC への接続処理の実装を担当するモデル
 */
class NlcClassifierModel
{
    protected $nlc_url; 
    protected $username;
    protected $password;
    protected $classifier_id;  // NLC classfier-id
    protected $status; // NLCのステータス（avairable, training, unavairable）
    
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

            var_dump($result_json); exit;

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


}