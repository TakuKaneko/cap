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

class CorpusController extends Controller
{
    // コーパス管理画面の表示
    public function index() {
        return view('dashboard.corpusdemo', ['corpuses' => Corpus::all()]);
    }

    // CSVダウンロード
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

}
