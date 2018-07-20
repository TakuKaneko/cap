<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;          // DBのトランザクション利用
use Validator;

class ServiceController extends Controller
{
  /**
   * サービス管理画面表示
   */
  public function index() {

    // 認証チェック
    $user = Auth::user();
    if(is_null($user)) {
        return redirect('login'); // ログアウト
    }

    //自分の企業のユーザー取得
    $my_company_users = User::where('company_id', $user->company_id)->orderByRaw('id=' . $user->id . ' desc, id asc')->get();

    // 表示
    return view('dashboard.settings', ['users' => $my_company_users, 'my_user_id' => $user->id]);
  }


  /**
   * ユーザ作成
   */
  public function registerUser(Request $request) {
    // 認証チェック
    $user = Auth::user();
    if(is_null($user)) {
        return redirect('login'); // ログアウト
    }

    // バリデーション
    $validator = Validator::make($request->all(), User::$create_rule, User::$create_error_messages);
    if($validator->fails()) {
      return redirect('/settings')->withErrors($validator);
    }


    // 登録処理
    DB::beginTransaction();

    try {

      User::create([
        'sei_kanji' => $request['sei_kanji'],
        // 'sei_kanji' => NULL,
        'mei_kanji' => $request['mei_kanji'],
        'email' => $request['email'],
        'password' => bcrypt($request['password']),
        'role' => UserRole::User,
        'company_id' => $user->company_id,
        'deleted_at' => NULL,
        'remember_token' => ""
      ]);

      DB::commit();

    } catch (\PDOException $e){
      DB::rollBack();
      return redirect('/settings')->withErrors(array('アカウントの登録に失敗しました'));
    }

    return redirect('/settings')->with('msg', 'ユーザ登録が完了しました');
  }


  /**
   * ユーザの編集
   */
  public function editUser(Request $request) {

    // 認証チェック
    $user = Auth::user();
    if(is_null($user)) {
        return redirect('login'); // ログアウト
    }

    $edit_user_id = $request->edit_user_id;
    if(empty($edit_user_id)) {
      return redirect('/settings')->withErrors(array('リクエストパラメータが不正です'));
    }

    $edit_user = User::where('id', $edit_user_id)->where('company_id', $user->company_id)->first();
    if(empty($edit_user)) {
      return redirect('/settings')->withErrors(array('リクエストパラメータが不正です'));
    }

    $current_email = $edit_user->email;
    

    // バリデーション
    $validator = Validator::make($request->all(), User::$edit_rule, User::$edit_error_messages);
    
    if($request->email !== $current_email) {
      $validator->sometimes('email', 'required|string|email|max:255|unique:users', function($input) {
        return $input->email;
      });
    }    

    $validator->sometimes('password', 'required|string|min:6', function($input) {
      return !empty($input->password);
    });

    if($validator->fails()) {
      return redirect('/settings')->withErrors($validator);
    }


    // 編集処理
    DB::beginTransaction();

    try {
      $user = User::find($edit_user_id);
      $user->sei_kanji = $request->sei_kanji;
      $user->mei_kanji = $request->mei_kanji;
      $user->email = $request->email;
      if(!empty($request->password)) {
        $user->password = bcrypt($request['password']);
      }
      $user->save();

      DB::commit();

    } catch (\PDOException $e){
      DB::rollBack();
      return redirect('/settings')->withErrors(array('アカウントの編集に失敗しました'));
    }

    return redirect('/settings')->with('msg', 'ユーザ編集が完了しました');

  }

  /**
   * ユーザ削除
   */
  public function deleteUser(Request $request) {

    // 認証チェック
    $user = Auth::user();
    if(is_null($user)) {
        return redirect('login'); // ログアウト
    }

    $delete_user_id = $request->delete_user_id;
    if(empty($delete_user_id)) {
      return redirect('/settings')->withErrors(array('リクエストパラメータが不正です'));
    }

    $delete_user = User::where('id', $delete_user_id)->where('company_id', $user->company_id)->first();
    if(empty($delete_user)) {
      return redirect('/settings')->withErrors(array('リクエストパラメータが不正です'));
    }


    // 削除処理
    DB::beginTransaction();
      
    try {
      $delete_user->delete();
      DB::commit();

    } catch (\PDOException $e){
      DB::rollBack();
      return redirect('/settings')->withErrors(array('アカウントの編集に失敗しました'));
    }
    

    return redirect('/settings')->with('msg', 'ユーザ削除が完了しました');

  }

}
