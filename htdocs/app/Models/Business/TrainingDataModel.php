<?php

namespace App\Models\Business;

use App\Models\CorpusClass;
use App\Models\CorpusCreative;

use App\Enums\CorpusDataType;

use Illuminate\Support\Facades\DB;          // DBのトランザクション利用
use Carbon\Carbon;

/**
 * AI学習のための教師データの取り扱いを実装するモデル
 */
class TrainingDataModel
{
    // const ROOT_PATH = "/files/corpus-admin/training-datas/";
    // const ROOT_PATH =  __FILE__;
    const SAVE_FILE_PATH = '/../../../public/files/corpus-admin/training-datas/';
    protected $corpus_id; // コーパスID
    protected $file_name; // ファイル名
    protected $record_cnt; // レコード件数
    protected $err_msg; // エラーメッセージ
    
    /**
     * コンストラクタ
     */
    public function __construct($corpus_id)
    {
        $this->corpus_id = $corpus_id;
    }

    /**
     * DBから教師データ情報を抽出し、所定フォルダにCSV保存する
     */
    public function saveTrainingDataCsv()
    {
        try {

            // 対象コーパスのクリエイティブ取得
            $training_data = CorpusCreative::select()
                ->join('corpus_classes','corpus_classes.id','=','corpus_creatives.corpus_class_id')
                ->whereIn('corpus_classes.corpus_id', [$this->corpus_id])
                ->where('corpus_creatives.data_type', CorpusDataType::Training)
                ->get();

            // ファイル名
            $timestamp = Carbon::now()->timestamp;
            $this->file_name = "training_data_" . $timestamp . ".csv";

            // ファイルパス
            $save_filepath = dirname(__FILE__) . self::SAVE_FILE_PATH . $this->file_name;

            // CSV形式で保存
            if(touch($save_filepath)) {
                // 書き込み
                $file = new \SplFileObject($save_filepath, "w");

                foreach($training_data as $data) {
                    $csv = [$data->content, $data->name];
                    $file->fputcsv($csv);
                }

                $file = null;
            }

            // レコード件数保存
            $this->record_cnt = count($training_data);


        } catch (\Exception $e) {
            $this->err_msg = $e->getMessage();
            // $this->err_msg = $e->getMessage('学習実行用のテキストデータ取得に失敗しました');
        }

        $this->err_msg = "";
        return;

    }

    /**
     * 教師データのCSVファイルの保存パスを返す
     */
    public function getTrainingDataPath()
    {
        // return ROOT_PATH . $this->file_name;
        return dirname(__FILE__) . self::SAVE_FILE_PATH . $this->file_name;
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


    /**
     * 対象のクリエイティブに学習完了日をセットする
     */
    public function setTrainingDoneDate() {

        // 登録処理
        DB::beginTransaction();

        try {
            $class_id_list = CorpusClass::where('corpus_id', $this->corpus_id)->get(['id']);
            $training_data = CorpusCreative::whereIn('corpus_class_id', $class_id_list)
                ->where('data_type', CorpusDataType::Training)
                ->get();

            $now = Carbon::now();
            foreach($training_data as $data) {
                $creative = CorpusCreative::find($data->id);
                $creative->training_done_data = $now;
                $creative->save();
                unset($creative);
            }
    
            DB::commit();

        } catch (\PDOException $e){
            DB::rollBack();
            $this->err_msg = $e->getMessage();           
        }

        $this->err_msg = "";
        return;
        
    }

}