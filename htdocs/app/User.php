<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sei_kanji', 'mei_kanji', 'email', 'password', 'role', 'company_id', 'delete_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * 新規作成バリデーション
     */
    public static $create_rule = array(
        'sei_kanji' => 'required|string|max:255',
        'mei_kanji' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6',
    );

    public static $create_error_messages = array(
        'sei_kanji.required' => "姓を入力してください",
        'sei_kanji.string' => "姓は文字で入力してください",
        'sei_kanji.max' => "姓は255字以内で入力してください",
        'mei_kanji.required' => "名を入力してください",
        'mei_kanji.string' => "名は文字で入力してください",
        'mei_kanji.max' => "名は255字以内で入力してください",
        'email.required' => "メールアドレスを入力してください",
        'email.string' => "メールアドレスは文字で入力してください",
        'email.email' => "メールアドレスの形式で入力してください",
        'email.max' => "メールアドレスは255字以内で入力してください",
        'email.unique' => "既に同じメールアドレスが登録されています",
        'password.required' => 'パスワードを入力してください',
        'password.string' => 'パスワードは文字で入力してください',
        'password.min' => 'パスワードは6文字以上で指定してください',
    );

    /**
     * 編集バリデーション
     */
    public static $edit_rule = array(
        'sei_kanji' => 'required|string|max:255',
        'mei_kanji' => 'required|string|max:255',
    );

    public static $edit_error_messages = array(
        'sei_kanji.required' => "姓を入力してください",
        'sei_kanji.string' => "姓は文字で入力してください",
        'sei_kanji.max' => "姓は255字以内で入力してください",
        'mei_kanji.required' => "名を入力してください",
        'mei_kanji.string' => "名は文字で入力してください",
        'mei_kanji.max' => "名は255字以内で入力してください",
        'email.required' => "メールアドレスを入力してください",
        'email.string' => "メールアドレスは文字で入力してください",
        'email.email' => "メールアドレスの形式で入力してください",
        'email.max' => "メールアドレスは255字以内で入力してください",
        'email.unique' => "既に同じメールアドレスが登録されています",
        'password.required' => 'パスワードを入力してください',
        'password.string' => 'パスワードは文字で入力してください',
        'password.min' => 'パスワードは6文字以上で指定してください',
    );

}
