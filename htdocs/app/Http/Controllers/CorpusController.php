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
use App\Models\Corpus;
use App\Models\CorpusClass;
use App\Models\CorpusCreative;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;          // DBのトランザクション利用
use App\Enums\CorpusStateType;
use App\Enums\CorpusDataType;

class CorpusController extends Controller
{
    // コーパス管理画面の表示
    public function index() {
      return view('dashboard.corpusdemo', ['corpuses' => Corpus::all()]);
    }


    /**
     * コーパス データ管理画面
     */
    public function corpusDataView($corpus_id) {
      if($corpus_id === null) {
        throw new \Exception('パラメータが不正です...');
      }

      $corpus_info = Corpus::find($corpus_id);
      $classes = CorpusClass::where('corpus_id', $corpus_id)->get();
      
      $training_crative_list = [];
      $test_crative_list = [];

      foreach($classes as $class) {
        // 対象のクラスidのクリエイティブを取得して
        $class_id = $class->id;
        $creatives = CorpusCreative::where('corpus_class_id', $class_id)->orderBy('updated_at', 'desc')->get();

        $training_crative_list[$class_id] = [];
        $test_crative_list[$class_id] = [];
        // 学習/テストで振り分ける
        foreach($creatives as $creative) {
          $data_type = (int)$creative->data_type;
          
          
          if($data_type === CorpusDataType::Training) {
            $training_crative_list[$class_id][] = $creative;

          } else if($data_type === CorpusDataType::Test) {
            $test_crative_list[$class_id][] = $creative;

          }
        }

      }

      return view('corpus-admin.ca-data-view', [
        'corpus_id' => $corpus_id, 
        'corpus_info' => $corpus_info,
        'corpus_classes' => $classes,
        'training_creatives' => $training_crative_list,
        'test_creatives' => $test_crative_list
      ]);

    }


    /**
     * クリエイティブの新規作成
     */
    public function createCreative($corpus_id, Request $request) {
      $form = $request->all();

      // 新規のクラス追加があるかどうか
      $add_class_flag = false;

      if($form['corpus_class_id'] === null) {
        $add_class_rule = [
          'add_class_name' => 'required'
        ];
        $this->validate($request, $add_class_rule);

        $add_class_flag = true; 
      }


      // バリデーション
      $creative_rule = [
        'content' => 'required|between:1,1000'
      ];
      $this->validate($request, $creative_rule);


      // 登録処理
      DB::beginTransaction();

      // 処理完了のリダイレクト時にフロント側に情報を渡すためのもの
      // $with_res = $this->getResponseForJs();

      try {
        $get_data_type = (int)$form['data_type'];
        $corpus_class_id = $form['corpus_class_id'];


        if($add_class_flag) {
          // 同じ名前のクラス名がないかどうか
          $add_class_name = $form['add_class_name'];

          $count = CorpusClass::where('corpus_id', $corpus_id)->where('name', 'like binary', $add_class_name)->count();
          $this->logInfo($count);

          if($count > 0) {
            throw new \Exception('既に同じクラス名が存在しています...');

          } else {
            // クラス登録
            $class = new CorpusClass;
            $class->name = $add_class_name;
            $class->corpus_id = $corpus_id;
            $class->threshold = null;
            $class->training_data_count = 0;
            $class->test_data_count = 0;
            $class->save();
          }

          $corpus_class_id = $class->id;
        }


        // 登録
        $creative = new CorpusCreative;
        $creative->corpus_class_id = $corpus_class_id;
        $creative->data_type = $get_data_type;
        $creative->content = $form['content'];
        $creative->save();


        // クラスのデータ件数の更新
        $this->logInfo('クラスのデータ件数更新');
        $this->logInfo($corpus_class_id);
        $update_class = CorpusClass::find($corpus_class_id);
        

        if($get_data_type === CorpusDataType::Training) {
          $count = $update_class->training_data_count;
          $count++;
          $update_class->training_data_count = $count;

        } else if($get_data_type === CorpusDataType::Test) {
          $count = $update_class->test_data_count;
          $count++;
          $update_class->test_data_count = $count;
        }
        $update_class->save();

        DB::commit();


      } catch (\PDOException $e){
        DB::rollBack();

        return redirect('/corpus/data/view/' . $corpus_id)
          ->with('error_msg', 'データベースへの登録に失敗しました...');

      } catch(\Exception $e) {
        DB::rollBack();

        return redirect('/corpus/data/view/' . $corpus_id)
         ->with('error_msg', $e->getMessage());

      }

      // 処理完了
      return redirect('/corpus/data/view/' . $corpus_id)
        ->with('success_msg', '登録が完了しました');
      
    }


    /**
     * クリエイティブの編集
     */
    public function editCreative($corpus_id, Request $request) {
      $form = $request->all();


      $valid_rule = [
        'content' => 'required|between:1,1000',
        'corpus_class_id' => 'required',
        'creative_id' => 'required'
      ];
      $this->validate($request, $valid_rule);


      // 更新処理
      DB::beginTransaction();

      try {
        $get_data_type = (int)$form['data_type'];
        $edit_class_id = $form['corpus_class_id'];

        $this->logInfo($get_data_type);

        // 更新
        $creative = CorpusCreative::find($form['creative_id']);
        $current_class_id = $creative->corpus_class_id;         // 所属するクラスに変更があったかどうか判断する用

        $creative->corpus_class_id = $edit_class_id;
        $creative->content = $form['content'];
        $creative->save();

        $this->logInfo($edit_class_id);
        $this->logInfo($current_class_id);
        

        // クラスが変更になっていたらクラスのデータ件数の更新
        if($edit_class_id !== $current_class_id) {

          // 編集されたクラスは+1
          $update_class = CorpusClass::find($edit_class_id);
          if($get_data_type === CorpusDataType::Training) {
            $this->logInfo('Training');

            $count = $update_class->training_data_count;
            $count++;
            $update_class->training_data_count = $count;
  
          } else if($get_data_type === CorpusDataType::Test) {
            $this->logInfo('Test');

            $count = $update_class->test_data_count;
            $count++;
            $update_class->test_data_count = $count;
          }
          $update_class->save();

          // 元のクラスは-1
          $current_class = CorpusClass::find($current_class_id);
          if($get_data_type === CorpusDataType::Training) {
            $this->logInfo('Training');

            $count = $current_class->training_data_count;
            $count--;
            $current_class->training_data_count = $count;
  
          } else if($get_data_type === CorpusDataType::Test) {
            $this->logInfo('Test');

            $count = $current_class->test_data_count;
            $count--;
            $current_class->test_data_count = $count;
          }
          $current_class->save();
        }

        DB::commit();


      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', 'データベースへの登録に失敗しました...');

      } catch(\Exception $e) {
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', $e->getMessage());

      }

      // 処理完了
      return redirect('/corpus/data/view/' . $corpus_id)->with('success_msg', '編集が完了しました');

    }


    /**
     * クリエイティブの削除
     */
    public function deleteCreative($corpus_id, Request $request) {
      $form = $request->all();

      $valid_rule = [
        'creative_id' => 'required'
      ];
      $this->validate($request, $valid_rule);


      // 削除処理
      DB::beginTransaction();

      try {
        $get_data_type = (int)$form['data_type'];

        // 削除
        $creative = CorpusCreative::find($form['creative_id']);
        $relate_class_id = $creative->corpus_class_id;
        $creative->delete();

        // データ件数更新
        $class = CorpusClass::find($relate_class_id);
        if($get_data_type === CorpusDataType::Training) {
          $count = $class->training_data_count;
          $count--;
          $class->training_data_count = $count;

        } else if($get_data_type === CorpusDataType::Test) {
          $count = $class->test_data_count;
          $count--;
          $class->test_data_count = $count;
        }
        $class->save();

        // 学習データが対象の時、学習データ件数が0件であれば
        // テストデータの関連クリエイティブを削除して、該当クラスを削除する
        if($get_data_type === CorpusDataType::Training) {
          $data_count = $class->training_data_count;
          $class_id = $class->id;

          $this->logInfo($data_count);
          $this->logInfo($class_id);

          if($data_count === 0) {
            $relate_creatives = CorpusCreative::where('corpus_class_id', $class_id);
            $relate_creatives->delete();

            $class->delete();
          }
        }

        DB::commit();


      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', 'データベースでの削除処理に失敗しました...');

      } catch(\Exception $e) {
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', $e->getMessage());

      }

      // 処理完了
      return redirect('/corpus/data/view/' . $corpus_id)->with('success_msg', 'テキストを削除しました');

    }


    /**
     * 学習データのCSVダウンロード
     */
    public function trainingDataDownload($corpus_id) {
      $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=training_data.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
      );
    
      $callback = function() use ($corpus_id) {
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
          ->whereIn('corpus_classes.corpus_id', [$corpus_id])
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
     * 学習データCSVアップロード
     */
    public function trainingDataUplocad($corpus_id, Request $request) {
      // CSVファイルがアップできたかどうか
      if(!$this->getCsvFileStatus($request)) {
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', 'ファイルのアップロードに失敗しました...');
      }


      // csvファイル読み込み
      $csv_tmp_file = $request->file('csv_file');
      $csv_file_path = $csv_tmp_file->path();

      $file = $this->loadCsvFile($csv_tmp_file);


      // CSVデータ件数チェック(範囲: 5-15000件)
      $res = $this->isAllowdCsvRow($file, $corpus_id);
      if(!$res) {
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', 'データ件数が5-15,000件になっていません...'); 
      }


      // データの登録・削除処理
      $transact_result = false;
      DB::beginTransaction();

      try {

        // 古いデータの削除
        $this->logInfo('古いデータ削除開始');
        $del_classes = CorpusClass::where('corpus_id', $corpus_id);

        $del_class_id_list = [];
        foreach($del_classes->get() as $class) {
          $del_class_id_list[] = $class->id;
        }
        $del_creatives = CorpusCreative::whereIn('corpus_class_id', $del_class_id_list);

        $del_classes->delete();
        $del_creatives->delete();


        // アップロードデータ登録処理
        $this->logInfo('データ登録処理開始');

        $loaded_csv_data = [];
        $class_list = [];
        $class_id_list = [];


        $file->rewind();
        foreach ($file as $line) {
          $this->logInfo('現在の行: ' . $file->key());

          // 最初の行をスキップ
          if($file->key() === 0) {
            continue;
          }

          // 文字コード変更
          mb_convert_variables('UTF-8', 'SJIS-win', $line);
          $content = $line[0];
          $class_name = $line[1];

          $this->logInfo($content . ',' . $class_name);

          if ($content === '' || $class_name === '') {
            throw new \Exception('CSVで入力されていないカラムが存在します...');
          }

          // 未登録のクラスの場合、登録する
          if(!array_key_exists($class_name, $class_list)) {
            // クラス登録
            $class = new CorpusClass;
            $class->name = $class_name;
            $class->corpus_id = $corpus_id;
            $class->threshold = null;
            $class->training_data_count = 0;              // あとで集計して更新する
            $class->test_data_count = 0;                  // あとで集計して更新する
            $class->save();

            $class_list[$class_name] = $class->id;
            $class_id_list[] = $class->id;
          }

          // クリエイティブの登録
          $creative = new CorpusCreative;
          $creative->corpus_class_id = $class_list[$class_name];
          $creative->data_type = CorpusDataType::Training;
          $creative->content = $content;
          $creative->save();

        }

        
        // クラスの登録件数更新
        $this->logInfo("クラスの登録件数更新");
        foreach($class_id_list as $class_id) {
          // 学習データ件数
          $training_data_count = CorpusCreative::where('corpus_class_id', $class_id)->where('data_type', CorpusDataType::Training)->count();
          $training_class = CorpusClass::find($class_id);
          $training_class->training_data_count = $training_data_count;
          $training_class->save();
        }

        // コーパスのステータス更新
        $this->logInfo("コーパスのステータス更新");
        $corpus = Corpus::find($corpus_id);
        $corpus->status = CorpusStateType::Untrained;
        $corpus->save();

        $this->logInfo("コミット");
        DB::commit();

      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', 'データベースへの登録に失敗しました...');

      } catch(\Exception $e) {
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', $e->getMessage());

      }

      $success_msg = 'アップロードに成功しました！';
      return redirect('/corpus/data/view/' . $corpus_id)->with('success_msg', $success_msg);

    }


    /**
     * テストデータCSVアップロード
     */
    public function testDataUplocad($corpus_id, Request $request) {

      // CSVファイルがアップできたかどうか
      if(!$this->getCsvFileStatus($request)) {
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', 'ファイルのアップロードに失敗しました...');
      }


      // csvファイル読み込み
      $csv_tmp_file = $request->file('csv_file');
      $csv_file_path = $csv_tmp_file->path();

      $file = $this->loadCsvFile($csv_tmp_file);


      // CSVデータ件数チェック(範囲: 5-15000件)
      $res = $this->isAllowdCsvRow($file, $corpus_id);
      if(!$res) {
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', 'データ件数が5-15,000件になっていません...'); 
      }


      // データの登録・削除処理
      $transact_result = false;
      DB::beginTransaction();

      try {

        // 古いデータの削除
        $this->logInfo('古いデータ削除開始');
        $current_classes = CorpusClass::where('corpus_id', $corpus_id);

        $current_class_id_list = [];
        $current_class_list = [];
        foreach($current_classes->get() as $class) {
          $current_class_id_list[] = $class->id;
          $current_class_list[$class->name] = $class->id;
        }

        $del_creatives = CorpusCreative::whereIn('corpus_class_id', $current_class_id_list)->where('data_type', CorpusDataType::Test);
        $del_creatives->delete();
        unset($del_creatives);


        $this->logInfo('既存のクラス');
        $this->logInfo($current_class_list);

        // アップロードデータ登録処理
        $this->logInfo('データ登録処理開始');


        $file->rewind();
        foreach ($file as $line) {
          $this->logInfo('現在の行: ' . $file->key());

          // 最初の行をスキップ
          if($file->key() === 0) {
            continue;
          }

          // 文字コード変更
          mb_convert_variables('UTF-8', 'SJIS-win', $line);
          $content = $line[0];
          $class_name = $line[1];

          $this->logInfo($content . ',' . $class_name);

          if ($content === '' || $class_name === '') {
            throw new \Exception('CSVで入力されていないカラムが存在します...');
          }

          // 既存のクラスかどうか判定
          
          if(!array_key_exists($class_name, $current_class_list)) {
            throw new \Exception('存在しないクラス名が指定されています...');
          }

          // クリエイティブの登録
          $creative = new CorpusCreative;
          $creative->corpus_class_id = $current_class_list[$class_name];
          $creative->data_type = CorpusDataType::Test;
          $creative->content = $content;
          $creative->save();

        }

        
        // クラスの登録件数更新
        $this->logInfo("クラスの登録件数更新");
        foreach($current_class_id_list as $class_id) {
          // テストデータ件数
          $test_data_count = CorpusCreative::where('corpus_class_id', $class_id)->where('data_type', CorpusDataType::Test)->count();
          $test_class = CorpusClass::find($class_id);
          $test_class->test_data_count = $test_data_count;
          $test_class->save();
        }

        $this->logInfo("コミット");
        DB::commit();

      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', 'データベースへの登録に失敗しました...');

      } catch(\Exception $e) {
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', $e->getMessage());

      }

      $success_msg = 'アップロードに成功しました！';
      return redirect('/corpus/data/view/' . $corpus_id)->with('success_msg', $success_msg);

    }
    

    /**
     * CSVファイルが正常にアップされたかどうか
     */
    private function getCsvFileStatus($request) {
      $bool = true;

      if(!$request->hasFile('csv_file')) {
        $bool = false;

      } else {
        $csv_tmp_file = $request->file('csv_file');
        if(!$csv_tmp_file->isValid()) {
          $bool = false;
        }

      }
      
      return $bool;
    }


    /**
     * CSV読み込み
     */
    private function loadCsvFile($path) {
      $file = new \SplFileObject($path);

      $file->setFlags(
        \SplFileObject::READ_CSV |         // CSV 列として行を読み込む
        \SplFileObject::READ_AHEAD |       // 先読み/巻き戻しで読み出す。
        \SplFileObject::SKIP_EMPTY |       // 空行は読み飛ばす
        \SplFileObject::DROP_NEW_LINE      // 行末の改行を読み飛ばす
      );

      return $file;
    }


    /**
     * CSV行数チェック
     */
    private function isAllowdCsvRow($file, $corpus_id) {
      $bool = true;

      // 行数チェック
      $row_count = 0;
      $min_row_count = 5;
      $max_row_count = 15000;

      $this->logInfo('行数チェック開始');
      foreach ($file as $line) {
        // 最初の行をスキップ
        if($file->key() === 0) {
          continue;
        }
        
        $row_count++;
      }  
      $this->logInfo('アップロードデータ件数: ' . $row_count);

      if ($row_count < $min_row_count || $max_row_count < $row_count) {
        $this->logInfo('範囲外です...');
        $bool = false;
      }

      return $bool;
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
