<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Api;
use App\Models\Business\NlcClassifierModel as NLC;
use DB;

/**
 * APIの実行管理コントローラー
 */
class ApiController extends Controller
{
    /**
     * CAP審査結果をAPIでレスポンス
     * @param Request $request ユーザーからのHTTPリクエストオブジェクト
     * @param String $display_api_id ユーザが指定したAPI-ID
     * @return String NLC実行結果をCAPフォーマットに変換したJSON文字列
     */
    public function getCognitiveAdCheckResult(Request $request, $display_api_id) {
        /* API認証の実行 */
        $token = $request->header('X-Pasonatech-Cap-Token');
        $auth_flg = $this->isAuthenticated($token);
        // 実在するdisplay_api_idであればapi_idを取得、実在しなければFALSE
        $api_id_flg = $this->changeApiId($display_api_id); 

        // エラー処理：認証失敗した場合
        if (!$auth_flg)
        {
            $res = array();
            $res['code'] = '401';
            $res['message'] = 'Unauthorized';
            $res['description'] = 'Can not connect because API authentication failed.\n Please reconnect with the correct authentication token.';

            return json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } 
        // エラー処理：API-IDが不正な場合
        elseif (!$api_id_flg)
        {
            $res = array();
            $res['code'] = '404';
            $res['message'] = 'Not found';
            $res['description'] = 'The specified API can not be found.';

            return json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        /* 認証成功の場合はNLCを実行し結果をユーザーにJSONで返す */
        // 認証トークンを元に会社情報を取得
        $company = Company::where('authroize_token', 'like', $token)->first();
        // NLCモデルを生成
        $classifier_id = Api::find($api_id_flg)->nlc_id;
        $nlc = new NLC($company->nlc_url, $company->nlc_username, $company->nlc_password, $classifier_id);

        // エラー処理：ステータスが Avairable 以外の場合
        if (!$nlc->isAvairable() or !$nlc->isQueryCorrect($request->input('text')))
        {
            $res = array();
            $res['code'] = '404';
            $res['message'] = 'Bad request';
            $res['description'] = 'Likely caused by a API status other than Available or by a missing text parameter.';

            return json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        // 分析結果を取得
        return $nlc->runCognitiveAdCheck($display_api_id, $request->input('text'));
    }

    /**
     * APIトークン認証の実行
     * @param String $request_token APIリクエストに付与された認証トークン
     * @return BOOLEAN 会社TBLに認証トークンを含むレコードが存在するばTRUEを返す
     */
    protected function isAuthenticated($request_token) {
        // Companiesテーブルの認証トークンカラムと突合チェック
        return Company::where('authroize_token', 'like', $request_token)->exists();
    }

    /**
     * DISPLAY-API-IDをAPI-IDに変換する
     * @param String $display_api_id API-ID
     * @return String/BOOLEAN API-IDが存在すれば、api.id を返し、存在しない場合はFALSEを返す。
     */
    protected function changeApiId($display_api_id) {
        // Apisテーブルに渡されたdisplay_api_idのデータがあればAPI-IDを返す
        $api = Api::where('display_api_id', 'like', $display_api_id)->first();

        return $api ? $api->id : false;
    }

    /**
     * 指定された企業に紐づくAPIの一覧を返す
     * @param String $company_id 
     * @return Collection API-TBLの中で、該当する会社IDをFKとして持つAPIのレコードを全て返す
     */
    public function getApiList($company_id = NULL) {
        if ($company_id != NULL)
        {
            return Company::find($company_id)->apis;
        }
        return Api::all();
    }


}
