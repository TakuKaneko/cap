<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorpusCreative extends Model
{
    /**
     * 新規作成バリデーション
     */
    public static $create_rule = array(
        'content' => 'required|between:0,1024'
    );

    public static $create_error_messages = array(
        'content.required' => 'テキストが入力されていません',
        'content.between' => 'テキストは1024文字以内で入力してください'
    );


    /**
     * 編集バリデーション
     */
    public static $edit_rule = array(
        'content' => 'required|between:0,1024',
        'corpus_class_id' => 'required',
        'creative_id' => 'required'
    );

    public static $edit_error_messages = array(
        'content.required' => 'テキストが入力されていません',
        'content.between' => 'テキストは1024文字以内で入力してください',
        'corpus_class_id.required' => 'クラス名を選択してください',
        'creative_id.required' => 'リクエストパラメータが不正です'
    );


    /**
     * 削除バリデーション
     */
    public static $delete_rule = array(
        'creative_id' => 'required'
    );

    public static $delete_error_messages = array(
        'creative_id.required' => 'リクエストパラメータが不正です'
    );


    /**
     * CSVアップロードバリデーション
     */
    public static $csv_upload_rule = array(
        'content' => 'required|between:0,1024'
    );

    public static $csv_upload_error_message = array(
        'content.required' => 'テキストが入力されていないセルが存在します',
        'content.between' => '1024文字以内でないテキストが存在します'
    );
}
