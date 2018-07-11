<?php

/*
 * This file is part of the CAP service.
 *
 * Copyright © <2018> PASONATECH.CO., LTD. All rights reserved.
 * 
 * This source code or any portion thereof must not be
 * reproduced or used in any manner whatsoever.
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Corpus;
use App\Models\CorpusClass;
use App\Models\CorpusCreative;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;          // DBのトランザクション利用

class CorpusController extends Controller
{
    // コーパス管理画面の表示
    public function index() {
      return view('dashboard.corpusdemo', ['corpuses' => Corpus::all()]);
    }

    /**
     * 学習データのCSVダウンロード
     */
    public function trainingDataDownload($id) {
      $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=training_data.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
      );
    
      $callback = function() use ($id) {
        $handle = fopen('php://output', 'w');
  
        // ヘッダー（1行目）
        $columns = [
          'テキスト（この行は削除しないでください。）',
          'クラス',
        ];
        mb_convert_variables('SJIS-win', 'UTF-8', $columns);
        fputcsv($handle, $columns);


        // データ（2行目以降）
        $training_data = CorpusCreative::select()
          ->join('corpus_classes','corpus_classes.id','=','corpus_creatives.corpus_class_id')
          ->whereIn('corpus_classes.corpus_id', [$id])
          ->get();

        foreach ($training_data as $data) {
          $csv = [
            $data->content,
            $data->name
          ];
          mb_convert_variables('SJIS-win', 'UTF-8', $csv);
          fputcsv($handle, $csv);
        }
  
        fclose($handle);
      };
    
      return response()->stream($callback, 200, $headers);
    }


    /**
     * 学習データ/検証データCSVアップロード
     */
    public function trainingDataUplocad($corpus_id, $type, Request $request) {
      // 各種チェック
      if(!$request->hasFile('csv_file')) {
        return redirect('/corpus/data/view/' . $corpus_id)
          ->with('error_msg', 'リクエストにファイルがありませんでした...');
      }

      $csv_tmp_file = $request->file('csv_file'); 
      if(!$csv_tmp_file->isValid()) {
        return redirect('/corpus/data/view/' . $corpus_id)
          ->with('error_msg', 'ファイルのアップロードに失敗しました...');
      }


      // CSVを読み込む
      $path = $csv_tmp_file->path();
      $file = new \SplFileObject($path);
      $file->setFlags(
        \SplFileObject::READ_CSV |         // CSV 列として行を読み込む
        \SplFileObject::READ_AHEAD |       // 先読み/巻き戻しで読み出す。
        \SplFileObject::SKIP_EMPTY |       // 空行は読み飛ばす
        \SplFileObject::DROP_NEW_LINE      // 行末の改行を読み飛ばす
      );


      // データの登録・削除処理
      $transact_result = false;
      DB::beginTransaction();

      try {
        // 古いデータの削除
        $del_classes = CorpusClass::where('corpus_id', $corpus_id);

        $del_class_id_list = [];
        foreach($del_classes->get() as $class) {
          $del_class_id_list[] = $class->id;
        }
        $del_creatives = CorpusCreative::whereIn('corpus_class_id', $del_class_id_list);

        $del_classes->delete();
        $del_creatives->delete();


        // アップロードデータ登録処理
        $loaded_csv_data = [];
        $class_list = [];
        $class_id_list = [];

        foreach ($file as $line) {
          // 最初の行をスキップ
          if($file->key() === 0) {
            continue;
          }

          // 文字コード変更
          mb_convert_variables('UTF-8', 'SJIS-win', $line);
          $content = $line[0];
          $class_name = $line[1];

          $this->logInfo($content . ',' . $class_name);
          
          // 未登録のクラスの場合、登録する
          if(!array_key_exists($class_name, $class_list)) {
            // クラス登録
            $class = new CorpusClass;
            $class->name = $class_name;
            $class->corpus_id = $corpus_id;
            $class->threshold = null;
            $class->data_count = 0;              // あとで集計して更新する
            $class->data_type = 'production';    // あとで修正する
            $class->save();

            $class_list[$class_name] = $class->id;
            $class_id_list[] = $class->id;
          }

          // クリエイティブの登録
          $creative = new CorpusCreative;
          $creative->corpus_class_id = $class_list[$class_name];
          $creative->content = $content;
          $creative->save();

        }

        
        // クラスの登録件数更新
        foreach($class_id_list as $class_id) {
          $class_count = CorpusCreative::where('corpus_class_id', $class_id)->count();

          $class = CorpusClass::find($class_id);
          $class->data_count = $class_count;
          $class->save();
        }

        DB::commit();

      } catch (\PDOException $e){
        DB::rollBack();

        return redirect('/corpus/data/view/' . $corpus_id)
          ->with('error_msg', 'データベースへの登録に失敗しました...');
      }

      $success_msg = 'アップロードに成功しました！';
      return redirect('/corpus/data/view/' . $corpus_id)
        ->with('success_msg', $success_msg);

    }


    /**
     * 開発ログ確認用
     */
    private $debug = false;
    private function logInfo($msg) {
      if($this->debug) {
        echo $msg . '<br>';
      }
        
    }

}
