<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorpusClass extends Model
{
    /**
     * CSVアップロード用バリデーション
     */
    public static $csv_insert_rule = array(
        'class_name' => 'required'
    );

    public static $csv_insert_error_message = array(
        'class.required' => 'クラス名が空欄のセルが存在します'
    );


}
