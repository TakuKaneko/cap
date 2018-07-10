<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Api;
use App\Enums\CorpusStateType;

class ApiInfoController extends Controller
{
    /**
     * API管理画面の表示
     */
    public function index() {
        // ユーザの企業情報の取得
        $user = Auth::user();
        $company_id = $user->company_id;

        // 該当企業コードで登録されているAPIの一覧を取得
        $api_list_get = Api::where('company_id', $company_id)->get();
        $api_list = array();
        // foreach ($api_list as $api) {
        //     return $api->name; //->corpus_id;
        //     foreach ($corpuses as $corpus) {
        //         return $corpus->pivot;
        //     }
        // }exit;

        // APIの一覧をViewに返す
        return view('dashboard.api-info');
    }
}
