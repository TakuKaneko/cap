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

use App\Models\Api;
use App\Models\CompanyApi;
use App\Models\ApiCorpus;
use App\Models\Corpus;
use App\Models\CorpusClass;
use App\Models\CorpusCreative;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;          // DBのトランザクション利用
use Validator;

use App\Enums\CorpusStateType;
use App\Enums\CorpusDataType;
use App\Enums\CorpusType;
use App\Enums\ClassifierLanguage;

class CorpusController extends Controller
{
    // コーパス一覧画面の表示
    public function index() {

      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      $company_id = $user->company_id;
    
      // コーパス一覧取得
      $corpuses = Corpus::where('company_id', $company_id)->orderBy('is_production', 'desc')->orderBy('created_at', 'desc')->get();

      foreach($corpuses as $index => $corpus) {
        // 関連apiのテキスト追加
        $related_api_text = "";

        $api_corpus = ApiCorpus::where('corpus_id', $corpus->id)->first();
        if(!empty($api_corpus)) {
          $api_id = $api_corpus->api_id;

          $api = Api::find($api_id);
          if(!empty($api)) {
            $related_api_text = $api->name;
          }
        }
        $corpuses[$index]['related_api_text'] = $related_api_text;
      }

      return view('dashboard.corpusdemo', ['corpuses' => $corpuses, 'language_list' => ClassifierLanguage::getList()]);
    }


    /**
     * コーパスの新規作成
     */
    public function createCorpus(Request $request) {

      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      // バリデーション
      $validator = Validator::make($request->all(), Corpus::$create_rule, Corpus::$create_error_messages);
      if($validator->fails()) {
        return redirect('/corpus')->withErrors($validator)->withInput();
      }
      
      $form = $request->all();

      // 登録処理
      DB::beginTransaction();

      try {
        $corpus = new Corpus;
        $corpus->name = $form['name'];
        $corpus->description = $form['description'];
        $corpus->service_identify_id = "";
        $corpus->status = CorpusStateType::NoTrainingData;
        $corpus->type = CorpusType::NationalLanguage;
        $corpus->is_production = false;
        $corpus->company_id = $user->company_id;
        $corpus->language = $form['language'];
        $corpus->save();

        DB::commit();

      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('corpus')->with('error_msg', 'コーパスの作成に失敗しました')->withInput();

      };

      // 処理成功
      return redirect('corpus')->with('success_msg', 'コーパスが作成されました');

    }



    /**
     * コーパスの削除
     */
    public function deleteCorpus(Request $request) {

      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      // バリデーション
      $validator = Validator::make($request->all(), Corpus::$delete_rule, Corpus::$delete_error_messages);
      if($validator->fails()) {
        return redirect('/corpus')->withErrors($validator);
      }


      $form = $request->all();
      $corpus_id = $form['corpus_id'];

      // 登録処理
      DB::beginTransaction();

      try {
        // コーパスの削除
        $corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id);
        // $corpus = Corpus::where('id', $corpus_id)->where('company_id', '9999');
        
        if(!empty($corpus)) {
          $corpus->delete();

          // 関連するクラス、クリエイティブの削除
          $del_classes = CorpusClass::where('corpus_id', $corpus_id);
  
          $del_class_id_list = [];
          foreach($del_classes->get() as $class) {
            $del_class_id_list[] = $class->id;
          }
          $del_creatives = CorpusCreative::whereIn('corpus_class_id', $del_class_id_list);
  
          $del_classes->delete();
          $del_creatives->delete();
  
          DB::commit();

        } else {
          throw new \PDOException();
        }

      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('/corpus')->with('error_msg', 'コーパスの削除に失敗しました');

      };

      // 処理成功
      return redirect('/corpus')->with('success_msg', 'コーパスの削除が完了しました');
    }



    /**
     * コーパス管理画面
     */
    public function corpusView($corpus_id) {

      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      // コーパス情報取得
      $corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->first();
      return view('corpus-admin.ca-detail', ['corpus' => $corpus,  'language_list' => ClassifierLanguage::getList()]);
    }



    /**
     * コーパスの編集
     */
    public function editCorpus(Request $request) {
      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      // フォーム入力値チェック
      $validator = Validator::make($request->all(), Corpus::$create_rule, Corpus::$create_error_messages);
      if($validator->fails()) {
        return redirect('/corpus/view/'. $corpus_id)->withErrors($validator)->withInput();
      }

      $form = $request->all();
      $corpus_id = $form['corpus_id'];

      // 登録処理
      DB::beginTransaction();

      try {
        $corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->first();
        $corpus->name = $form['name'];
        $corpus->description = $form['description'];
        $corpus->language = $form['language'];
        $corpus->save();

        DB::commit();

      } catch (\PDOException $e){
        DB::rollBack();

        return redirect('/corpus/view/'. $corpus_id)
          ->with('error_msg', 'コーパスの編集に失敗しました')->withInput();
      };

      // 処理成功
      return redirect('/corpus/view/'. $corpus_id)->with('success_msg', 'コーパスの編集が完了しました');

    }


    /**
     * コーパス データ管理画面
     */
    public function corpusDataView($corpus_id) {

      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }
      

      $corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->first();
      $classes = CorpusClass::where('corpus_id', $corpus->id)->get();
      
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
        'corpus' => $corpus, 'corpus_classes' => $classes,
        'training_creatives' => $training_crative_list, 'test_creatives' => $test_crative_list
      ]);

    }
    


    /**
     * クリエイティブの新規作成
     */
    public function createCreative($corpus_id, Request $request) {

      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }


      // フォーム入力値チェック
      $validator = Validator::make($request->all(), CorpusCreative::$create_rule, CorpusCreative::$create_error_messages);

      $validator->sometimes('add_class_name', 'required', function($input) {
        return $input->corpus_class_id === null;
      });

      if($validator->fails()) {
        return redirect('/corpus/data/view/'. $corpus_id)->withErrors($validator);
      }

      // 
      $my_corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->count();
      if($my_corpus === 0) {
        throw new \Exception('リクエストパラメータが不正です');
      }


      $form = $request->all();

      // 登録処理
      DB::beginTransaction();

      try {
        $get_data_type = (int)$form['data_type'];
        $corpus_class_id = $form['corpus_class_id'];


        if($corpus_class_id === null) {
          $this->logInfo('新規のクラス登録を実施します');

          // 同じ名前のクラス名がないかどうか
          $add_class_name = $form['add_class_name'];
          $count = CorpusClass::where('corpus_id', $corpus_id)->where('name', 'like binary', $add_class_name)->count();
          $this->logInfo($count);

          if($count > 0) {
            throw new \Exception('既に同じクラス名が存在しています');

          } else {
            $this->logInfo('クラス新規登録');

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

          // コーパスのステータス更新
          // 学習データ登録時に教師データなしステータスだったら未学習に更新
          $corpus = Corpus::find($corpus_id);
          // dd($corpus->status);
          if((int)$corpus->status === CorpusStateType::NoTrainingData) {
            $corpus->status = CorpusStateType::Untrained;
            $corpus->save();
          }

        } else if($get_data_type === CorpusDataType::Test) {
          $count = $update_class->test_data_count;
          $count++;
          $update_class->test_data_count = $count;
        }
        $update_class->save();

        DB::commit();


      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', CorpusDataType::getDescription($get_data_type) . 'の登録に失敗しました');

      } catch(\Exception $e) {
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', $e->getMessage());

      }

      // 処理完了
      return redirect('/corpus/data/view/' . $corpus_id)->with('success_msg', CorpusDataType::getDescription($get_data_type) . 'の登録が完了しました');
    }



    /**
     * クリエイティブの編集
     */
    public function editCreative($corpus_id, Request $request) {
      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      // フォーム入力値チェック
      $validator = Validator::make($request->all(), CorpusCreative::$edit_rule, CorpusCreative::$edit_error_messages);

      if($validator->fails()) {
        return redirect('/corpus/data/view/'. $corpus_id)->withErrors($validator);
      }

      // 
      $my_corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->count();
      if($my_corpus === 0) {
        throw new \Exception('リクエストパラメータが不正です');
      }


      $form = $request->all();

      // 更新処理
      DB::beginTransaction();

      try {
        $get_data_type = (int)$form['data_type'];
        $edit_class_id = $form['corpus_class_id'];

        // 更新
        $creative = CorpusCreative::find($form['creative_id']);
        $current_class_id = $creative->corpus_class_id;         // 所属するクラスに変更があったかどうか判断する用

        $creative->corpus_class_id = $edit_class_id;
        $creative->content = $form['content'];
        $creative->save();
        

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

          // 元のクラスが0件になっていたら、削除する
          if((int)$current_class->training_data_count === 0) {
            // 関連するクリエイティブも削除
            $related_creative = CorpusCreative::where('corpus_class_id', $current_class->id);
            $related_creative->delete();

            // 自分を削除
            $current_class->delete();
          }
        }

        DB::commit();

      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', CorpusDataType::getDescription($get_data_type) . 'の編集に失敗しました');

      } catch(\Exception $e) {
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', $e->getMessage());
      }

      // 処理完了
      return redirect('/corpus/data/view/' . $corpus_id)->with('success_msg', CorpusDataType::getDescription($get_data_type) . 'の編集が完了しました');
    }


    /**
     * クリエイティブの削除
     */
    public function deleteCreative($corpus_id, Request $request) {
      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      // フォーム入力値チェック
      $validator = Validator::make($request->all(), CorpusCreative::$delete_rule, CorpusCreative::$delete_error_messages);
      if($validator->fails()) {
        return redirect('/corpus/data/view/'. $corpus_id)->withErrors($validator);
      }

      // 
      $my_corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->count();
      if($my_corpus === 0) {
        throw new \Exception('リクエストパラメータが不正です');
      }


      $form = $request->all();

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

          // 学習データが0件の時、コーパスステータスを未学習に更新
          if($count === 0) {
            $corpus = Corpus::find($corpus_id);
            $corpus->status = CorpusStateType::NoTrainingData;
            $corpus->save();
          }

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

          if($data_count === 0) {
            $relate_creatives = CorpusCreative::where('corpus_class_id', $class_id);
            $relate_creatives->delete();

            $class->delete();
          }
        }

        DB::commit();

      } catch (\PDOException $e){
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', CorpusDataType::getDescription($get_data_type) . 'の削除に失敗しました');

      } catch(\Exception $e) {
        DB::rollBack();
        return redirect('/corpus/data/view/' . $corpus_id)->with('error_msg', $e->getMessage());
      }

      // 処理完了
      return redirect('/corpus/data/view/' . $corpus_id)->with('success_msg', CorpusDataType::getDescription($get_data_type). 'の削除が完了しました');

    }


    /**
     * 学習データのCSVダウンロード
     */
    public function trainingDataDownload($corpus_id) {
      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      // 
      $my_corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->count();
      if($my_corpus === 0) {
        throw new \Exception('リクエストパラメータが不正です');
      }


      // ダウンロードヘッダー
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
      // 認証チェック
      $user = Auth::user();
      if($user === null) {
        return redirect('login'); // ログアウト
      }

      // 
      $my_corpus = Corpus::where('id', $corpus_id)->where('company_id', $user->company_id)->count();
      if($my_corpus === 0) {
        throw new \Exception('リクエストパラメータが不正です');
      }


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
     * 学習管理画面
     */
    public function trainingManage($corpus_id) {
      return view('corpus-admin.ca-training', ['corpus' => Corpus::find($corpus_id)]);
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
