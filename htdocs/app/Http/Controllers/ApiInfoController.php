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
        $api_list_get = Api::where('company_id', $company_id)->orderBy('created_at')->get();
        $api_list = array();
        foreach ($api_list_get as $key => $api) {
            // 注意：ver0.5 ではAPI対コーパスは1対1で紐付くのでfirst()で取得している。
            $corpus = $api->corpuses->first();

            $api_list[$key]["api_id"] = $api->id;
            $api_list[$key]["name"] = $api->name;
            $api_list[$key]["description"] = $api->description;
            $api_list[$key]["status_availability"] = $corpus->status == 0 ? '可' : '不可';
            $api_list[$key]["status_description"] = CorpusStateType::getDescription($corpus->status);
        }
        // return $api_list;

        // APIの一覧をViewに返す
        return view('dashboard.api-info');
    }

}
