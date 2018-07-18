<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Corpus extends Model
{

    /**
     * 新規作成バリデーション
     */
    public static $create_rule = array(
        'name' => 'required|between:0,191',
        'description' => 'required|between:0,191',
        'language' => 'required'
    );

    public static $create_error_messages = array(
        'name.required' => 'コーパス名が入力されていません',
        'name.between' => 'コーパス名は191文字以内で入力してください',
        'description.required' => '説明文が入力されていません',
        'description.between' => '説明文は191文字以内で入力してください',
        'language.required' => '言語を指定してください'
    );

    /**
     * 削除バリデーション
     */
    public static $delete_rule = array(
        'corpus_id' => 'required'
    );

    public static $delete_error_messages = array(
        'corpus_id.required' => 'パラメータが不明です...'
    );


    /**
     * このコーパスを所有するAPIを取得
     */
    public function apis()
    {
        return $this->belongsToMany('Api');
    }

}
