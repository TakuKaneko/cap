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
    public function getCapResult(Request $request) {
        // API認証の実行
        $token = $request->header('X-Pasonatech-Cap-Token');
        $auth_flg = $this->isAuthenticated($token);

        //-> 認証失敗した場合はエラーコードをJSONで返す
        if (!$auth_flg)
        {
            return response()->json([
                'code' => '401',
                'message' => 'Unauthorized',
                'description' => 'Can not connect because API authentication failed.\n Please reconnect with the correct authentication token.'
            ]);
        }

        //-> 認証成功の場合はAI判定結果をJSONで返す
        // NLCにクリエイティブを渡し、判定処理を実行
        $company = Company::find($this->getUserCompanyID($token))->first(); // ->select('nlc_url')
        $nlc = new NLC($company->nlc_url, $company->nlc_username, $company->nlc_password);

        var_dump( $nlc );exit;
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
     * アクセスユーザの所属会社IDを取得
     */
    public function getUserCompanyID ($request_token) {
        $company_id = Company::where('authroize_token', 'like', $request_token)->select('id')->first();
        return $company_id;
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
