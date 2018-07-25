@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span> 
  API管理
@endsection

@section('page-css')
  <link rel="stylesheet" type="text/css" href="{{ mix('/css/main/dashboard/api-info.css') }}" />
@endsection


@section('content')
      <style>
      </style>
      <div class="content">
        <div class="container-fluid">
          @if (session('msg'))
            <script>
              $(function(){
                type = ['', 'info', 'danger','success', 'warning', 'rose', 'primary'];
                color = Math.floor((Math.random() * 6) + 1);

                $.notify({
                  icon: "notifications",
                  message: "{{ session('msg') }}"
                }, {
                  type: 'success',
                  timer: 1000,
                  placement: {
                    from: 'top',
                    align: 'right'
                  }
                });
              });
            </script>
          @endif
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title">利用中のAPI一覧</h4>
                  <p class="card-category">現在契約しているAPIの一覧です。追加のご要望はサイト運営までご連絡ください。</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table active-api-table">
                      <thead class="text-brand">
                        <th></th>
                        <th>API-ID</th>
                        <th>API名</th>
                        <th>利用コーパス名</th>
                        <th>利用可否</th>
                        <th>ステータス</th>
                      </thead>
                      <tbody>
                        @foreach ($api_list as $key => $api)
                          <tr>
                            <td><label><input type="radio" name="display" checked> 表示</label></td>
                            <td>{{ $api["display_api_id"] }}</td>
                            <td>{{ $api["name"] }}</td>
                            <td>{{ $api["corpus_name"] }}</td>
                            <td>{{ $api["status_availability"] }}</td>
                            <td>{{ $api["status_description"] }}</td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <div class="card mt-0">
                <div class="card-body">
                  <p class="blockquote-footer mb-0">{{ $api_list[0]["display_api_id"] }}</p>
                  <h5 class="text-brand mt-0">{{ $api_list[0]["name"] }}</h5>
                  <ul class="nav nav-pills nav-pills-icons nav-pills-info nav-border" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" href="#api-resex" role="tab" data-toggle="tab">
                        API利用例
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#api-auth" role="tab" data-toggle="tab">
                        資格情報
                      </a>
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link" href="#api-use" role="tab" data-toggle="tab">
                        認証について
                      </a>
                    </li> -->
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="api-resex">
                      <div class="highlight">
                        <h5 class="bold text-default">リクエストサンプル</h5>
                        <div>
                          以下のフォーマットにて、審査リクエストを送る必要があります。</br>
                          認証トークンは「認証情報」タブにてご確認ください。
                        </div>
                        <p>※注意：審査するテキストは1024文字以内です。上限を超えた場合、下記のエラーコードがレスポンスされます。</p>
                        <pre class="doc-content"><code><span class="bold">GET</span> /api/exec/{api_id}</code></pre>
                        <p>リクエスト例）</p>
                        <pre class="doc-content"><code>curl -G 
    -H <span class="bold">"X-Pasonatech-Cap-Token:0123abcd"</span> <span style="color:green;"> //<- 認証トークンはHTTPリクエストのヘッダに必ず付加してください。</span>
    --data-urlencode "text: <span class="bold">今日は晴れです。</span>" "{{ config('app.api_exec_url') }}<span class="bold">001abcd-cap-0000</span>"</code></pre>

                        <h5 class="bold text-default">リクエストパラメータ</h5>
                        <table class="parameter_table">
                          <tr>
                            <th class="table_title">パラメータ名</th>
                            <th>型</th>
                            <th>内容</th>
                          </tr>
                          <tr>
                            <td>X-Pasonatech-Cap-Token</td>
                            <td>文字列</td>
                            <td>（※必須）API認証トークン</td>
                          </tr>
                          <tr>
                            <td>text</td>
                            <td>文字列</td>
                            <td>（※必須）審査対象テキスト</td>
                          </tr>
                          <tr>
                            <td>api_id</td>
                            <td>文字列</td>
                            <td>（※必須）API-ID</td>
                          </tr>
                        </table>

                        <hr>
                        <h5 class="bold text-default">レスポンスサンプル</h5>
                        <div>レスポンスには、API-ID と 入力したテキスト 、 その審査結果が含まれています。</div>
                        <span>リクエストがエラーになった場合は、以下のエラーレスポンスが返却されます。</span><br/><br />
                        <p>レスポンス例）以下は「今日は晴れです。」という審査テキストに対して、登録済みの各クラス（天気、気温、日時）それぞれの確信度を取得しています。</p>
<pre class="doc-content">
  <code class="hljs json">{
  <span class="hljs-attr">"api_id"</span> : <span class="hljs-string">"001abcd-cap-0000"</span>,
  <span class="hljs-attr">"url"</span>: <span class="hljs-string">"{{ config('app.api_exec_url') }}001abcd-cap-0000"</span>,
  <span class="hljs-attr">"text"</span>: <span class="hljs-string">"今日は晴れです。"</span>,
  <span class="hljs-attr">"passed_classes"</span>: [
    <span class="hljs-string">"天気"</span>,
    <span class="hljs-string">"日時"</span>
  ],
  <span class="hljs-attr">"results"</span>: [
    {
      <span class="hljs-attr">"class_name"</span>: <span class="hljs-string">"天気"</span>,
      <span class="hljs-attr">"confidence"</span>: 0.95012345678912345,
      <span class="hljs-attr">"threshold"</span>: 0.8,
      <span class="hljs-attr">"result"</span>: 1
    },
    {
      <span class="hljs-attr">"class_name"</span>: <span class="hljs-string">"気温"</span>,
      <span class="hljs-attr">"confidence"</span>: 0.05987654321987654,
      <span class="hljs-attr">"threshold"</span>: 0.8,
      <span class="hljs-attr">"result"</span>: 0
    },
    {
      <span class="hljs-attr">"class_name"</span>: <span class="hljs-string">"日時"</span>,
      <span class="hljs-attr">"confidence"</span>: 0.8596534321983653,
      <span class="hljs-attr">"threshold"</span>: 0.8,
      <span class="hljs-attr">"result"</span>: 1
    }
  ]
}
</code></pre>

                        <h5 class="bold text-default">レスポンスパラメータ</h5>
                        <table class="parameter_table">
                          <tr>
                            <th class="table_title">パラメータ名</th>
                            <th>型</th>
                            <th>内容</th>
                          </tr>
                          <tr>
                            <td>text</td>
                            <td>文字列</td>
                            <td>リクエストされた審査対象テキスト</td>
                          </tr>
                          <tr>
                            <td>passed_classes</td>
                            <td>配列</td>
                            <td>審査結果の確信度が閾値以上になったクラス（※閾値未設定の場合は最大確信度のクラスを返します。）</td>
                          </tr>
                          <tr>
                            <td>results</td>
                            <td>配列</td>
                            <td>審査結果の詳細（全クラスの結果を格納）</td>
                          </tr>
                          <tr>
                            <td>class_name</td>
                            <td>文字列</td>
                            <td>クラス名</td>
                          </tr>
                          <tr>
                            <td>confidence</td>
                            <td>数値</td>
                            <td>AIの審査確信度（0〜1の数値）</td>
                          </tr>
                          <tr>
                            <td>threshold</td>
                            <td>数値</td>
                            <td>確信度閾値（0〜1の数値）</td>
                          </tr>
                          <tr>
                            <td>result</td>
                            <td>数値</td>
                            <td>確信度が閾値以上の場合は1、閾値未満の場合は0 を返却</td>
                          </tr>
                        </table>

                        <h5 class="bold text-default">エラーレスポンス一覧</h5>
                        <table class="parameter_table">
                          <tr>
                            <th class="table_title">HTTPコード</th>
                            <th>メッセージ</th>
                            <th>説明</th>
                          </tr>
                          <tr>
                            <td>400</td>
                            <td>Bad request</td>
                            <td>APIに紐づくコーパスに問題があるか、審査対象のテキストに不備がある可能性があります。</td>
                          </tr>
                          <tr>
                            <td>401</td>
                            <td>Unauthorized</td>
                            <td>API認証に失敗しています。認証トークンに不備がある可能性があります。</td>
                          </tr>
                          <tr>
                            <td>404</td>
                            <td>Not found</td>
                            <td>指定されたAPI-IDが存在していません。API-IDの指定に不備がある可能性があります。</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane" id="api-auth">
                      <div class="table-responsive">
                        <table class="table api-auth-table">
                          <thead>
                            <th>URI</th>
                            <th>認証トークン</th>
                          </thead>
                          <tbody>
                            <tr>
                              <td>{{ config('app.api_exec_url') }}</td>
                              <td>{{ $api_list[0]["token"] }}</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <!-- <div class="tab-pane" id="api-use">
                      <div class="manual">
                        <h2 class="text-brand">開始</h2>
                        <span>最終更新日: 2017-11-21</span>
                        <p>Cognitive AD-Check Platform（以後、CAP）サービスは、ユーザのアプリケーションから入力されたクリエイティブの自然言語･描画内容を理解し、
                          その意図（以後、クラス）を識別するのに役立ちます。クラスは、教師データからトレーニングした後、
                          トレーニングされていないクリエイティブの予測クラス情報を返すことができるようになります。
                        </p>
                        <p>トレーニング完了時間目安：15 分未満</p>

                        <h3 class="manual-title">ステップ 1: 資格情報の取得</h3>
                        アプリケーションからCAPサービスにAPI接続するための認証に利用する資格情報を、隣のタブの「資格情報」画面から入手してください。



                      </div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection