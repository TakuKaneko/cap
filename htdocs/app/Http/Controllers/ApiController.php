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
     * AI判定結果のAPIレスポンス
     */
    public function getCognitiveAdCheckResult(Request $request, $api_id) {
        /* API認証の実行 */
        $token = $request->header('X-Pasonatech-Cap-Token');
        $auth_flg = $this->isAuthenticated($token);

        // エラー処理：認証失敗した場合
        if (!$auth_flg)
        {
            return response()->json([
                'code' => '401',
                'message' => 'Unauthorized',
                'description' => 'Can not connect because API authentication failed.\n Please reconnect with the correct authentication token.'
            ]);
        } 
        // エラー処理：API-IDが不正な場合
        elseif (!ctype_digit($api_id))
        {
            return response()->json([
                'code' => '404',
                'message' => 'Not found',
                'description' => 'The specified API can not be found.'
            ]);
        }

        /* 認証成功の場合はAI判定を実行し結果をユーザーにJSONで返す */
        // 認証トークンを元に会社情報を取得
        $company = Company::where('authroize_token', 'like', $token)->first();
        // NLCモデルを生成
        $classifier_id = Api::find($api_id)->nlc_id;
        $nlc = new NLC($company->nlc_url, $company->nlc_username, $company->nlc_password, $classifier_id);

        // エラー処理：ステータスが Avairable 以外の場合
        if (!$nlc->isAvairable() or !$nlc->isQueryCorrect($request->input('text')))
        {
            return response()->json([
                'code' => '400',
                'message' => 'Bad request',
                'description' => 'Likely caused by a API status other than Available or by a missing text parameter.'
            ]);
        }

        // 分析結果を取得
        $nlc->runClassify($request->input('text'));

        echo "end";exit;

    }

    /**
     * 独自API認証
     */
    public function isAuthenticated($request_token) {
        // Companiesテーブルの情報と合致（トークン、NLCのURL）するかチェック
        $res = Company::where('authroize_token', 'like', $request_token)->exists();
        return $res;
    }

    /**
     * 指定された企業に紐づくAPIの一覧を表示する
     */
    public function getApiList($company_id = NULL) {
        if ($company_id != NULL)
        {
            return Company::find($company_id)->apis;
        }
        return Api::all();
    }


}
