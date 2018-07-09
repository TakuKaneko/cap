<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiInfoController extends Controller
{
    // API管理画面の表示
    public function index() {
        // ユーザの企業情報の取得
        $user = Auth::user();
        $company_id = $user->company_id;
        // echo '<pre>' . var_export($user) . '</pre>';
        // exit;
        // 該当企業コードで登録されているAPIの一覧を取得
        // APIの一覧をViewに返す
        return view('dashboard.api-info');
    }
}
