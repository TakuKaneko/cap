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
    public function __construct($nlc_url, $username, $password)
    {
        $this->nlc_url = $nlc_url;
        $this->username = $username;
        $this->password = $password;
        $this->classifier_id = $this->createNlc("train.csv");
    }

    /**
     * NLC の生成
     */
    public function createNlc($data)
    {
        $curl_text = sprintf("curl -u \"%s\":\"%s\" -F training_data=@%s -F training_metadata=\"{\\\"language\\\":\\\"ja\\\",\\\"name\\\":\\\"My Classifier\\\"}\" -k \"%s\"",
                        $this->username, $this->password, $data, $this->nlc_url);

        $this->classifier_id = "000000000";
    }

    /**
     * NLC の実行
     */
    public function runClassify($creative)
    {
        // クリエイティブのバリデーション実施
        $res = $this->creativeValidation($creative);

        //-> バリデーションに失敗した場合、Falseを返し終了。
        if (!$res)
        {
            return false;
        }

        //-> バリデーションに成功した場合、NLCを実行し結果を返す。

    }

    /**
     * クリエイティブのバリデーション
     *  - ToDo：画像対応する際はDI化して引数はオブジェクトをとるようにする。
     */
    private function creativeValidation($creative)
    {
        $creative_length = mb_strlen($creative, 'UTF-8');
        echo $creative_length;exit;
    }

}