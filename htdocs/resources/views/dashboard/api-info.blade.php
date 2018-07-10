@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span> 
  API管理
@endsection

@section('content')
      <style>
        .nav-border {
          border-top: solid 1px lightgray;          
          border-bottom: solid 1px lightgray;
          padding: 3px;
          margin-bottom: 5px;
        }
        .doc-content {
          background: #d1d9e1;
          color: #2d2d2d;
          padding: 1em;
        }
        .api-auth-table th {
          width: 30%;
        }
        .manual-title {
          border-left: solid 5px cornflowerblue;
          padding-left: 7px;
          line-height: 2.5rem;
          margin-bottom: 10px;
        }
        .active-api-table tbody tr:hover {
          background-color: whitesmoke;
        }
        .hljs-attr {
          color: #795da3;
        }
        .hljs-number {
          color: #333;
        }
        .hljs-string {
          color: #df5000;
        }
        .bold {
          font-weight: bold;
        }
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
                      <thead class="text-info">
                        <th>説明表示</th>
                        <th>API-ID</th>
                        <th>API名</th>
                        <th>利用可否</th>
                        <th>ステータス</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td><input type="radio" name="description-disp-check" checked>表示</td>
                          <td>004a12x110-3450</td>
                          <td>景表法と薬機法の抵触リスクチェック</td>
                          <td>不可</td>
                          <td>エラー1101（教師データの学習が行われていません）</td>
                        </tr>
                        {{-- <tr>
                          <td><input type="radio" name="description-disp-check">表示</td>
                          <td>004a12x110-3451</td>
                          <td>メディア画像内の文言チェック</td>
                          <td>不可</td>
                          <td>エラー1101（学習が行われていません）</td>
                        </tr>   --}}
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
                  <p class="blockquote-footer mb-0">004a12x110-3450</p>
                  <h5 class="text-info mt-0">景表法と薬機法の抵触リスクチェック</h5>
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
                    <li class="nav-item">
                      <a class="nav-link" href="#api-use" role="tab" data-toggle="tab">
                        認証について
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="api-resex">
                      <div class="highlight">
                        <h5 class="bold">リクエストサンプル</h5>
                        <div>
                          以下のフォーマットにて、審査リクエストを送る必要があります。</br>
                          認証用のIDとパスワードは、「認証情報」タブにてご確認ください。
                        </div>
                        <p>※注意：審査するテキストは1024文字以内です。上限を超えた場合、エラーとなりエラーコードがレスポンスされます。</p>
                        <pre class="doc-content"><code>curl -X GET 
    -u "<span class="bold">認証ID</span>":"<span class="bold">認証パスワード</span>"
    -d "creative: <span class="bold">審査したいテキスト</span>" "https://cap.net/api/<span class="bold">:api_id</span>"</code></pre>

                        <p>レスポンスには、API-ID と 入力したテキスト 、 その識別結果が含まれています。以下に例を示します。</p>
<pre class="doc-content">
  <code class="hljs json">{
  <span class="hljs-attr">"api_id"</span> : <span class="hljs-string">"00000-cap-0000"</span>,
  "url": "https://cap.net/api/00000-cap-0000",
  "status": "avairable",
  "text": (リクエストされたテキスト),
  "passed_classes": [
    "天気",
    "日時"
  ],
  "results": [
    {
      "class_name": "天気",
      "confidence": 0.95012345678912345,
      "threshold": 0.8,
      "result": 1
    },
    {
      "class_name": "気温",
      "confidence": 0.05987654321987654,
      "threshold": 0.8,
      "result": 0
    },
    {
      "class_name": "日時",
      "confidence": 0.8596534321983653,
      "threshold": 0.8,
      "result": 1
    }
  ]
}
</code></pre>
                      </div>
                    </div>
                    <div class="tab-pane" id="api-auth">
                      <div class="table-responsive">
                        <table class="table api-auth-table">
                          <thead>
                            <th>URI</th>
                            <th>username</th>
                            <th>password</th>
                          </thead>
                          <tbody>
                            <tr>
                              <td>https://www.cap.net/api</td>
                              <td>1863db42-14e9-4313-be71-541db048053e</td>
                              <td>N0iHFHtmGxvQ</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="tab-pane" id="api-use">
                      <div class="manual">
                        <h2 class="text-info">開始</h2>
                        <span>最終更新日: 2017-11-21</span>
                        <p>Cognitive AD-Check Platform（以後、CAP）サービスは、ユーザのアプリケーションから入力されたクリエイティブの自然言語･描画内容を理解し、
                          その意図（以後、クラス）を識別するのに役立ちます。クラスは、教師データからトレーニングした後、
                          トレーニングされていないクリエイティブの予測クラス情報を返すことができるようになります。
                        </p>
                        <p>トレーニング完了時間目安：15 分未満</p>

                        <h3 class="manual-title">ステップ 1: 資格情報の取得</h3>
                        アプリケーションからCAPサービスにAPI接続するための認証に利用する資格情報を、隣のタブの「資格情報」画面から入手してください。



                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection