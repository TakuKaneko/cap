<?php

namespace App\Models\Business;

/**
 * AI学習のための教師データの取り扱いを実装するモデル
 */
class TrainingDataModel
{
    const ROOT_PATH = "/files/corpus-admin/training-datas/";
    protected $file_name; // ファイル名
    protected $record_cnt; // レコード件数
    protected $err_msg; // エラーメッセージ
    
    /**
     * コンストラクタ
     */
    public function __construct()
    {

    }

    /**
     * DBから教師データ情報を抽出し、所定フォルダにCSV保存する
     */
    public function saveTrainingDataCsv()
    {

    }

    /**
     * 教師データのCSVファイルの保存パスを返す
     */
    public function getTrainingDataPath()
    {
        return ROOT_PATH . $this->file_name;
    }

    /**
     * 教師データの件数を返す
     */
    public function getRecordCount()
    {
        return $this->record_cnt;
    }

    /**
     * 教師データ登録時のエラーメッセージを返す
     */
    public function getErrorMessage()
    {
        return $this->err_msg;
    }


}