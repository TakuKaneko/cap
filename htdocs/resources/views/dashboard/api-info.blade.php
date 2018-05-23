@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span> 
  API管理
@endsection

@section('content')
      <style>
        .tab-content {
          border-top: solid 1px lightgray;
          margin-top: 5px;
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
                          <td>可</td>
                          <td>-</td>
                        </tr>
                        <tr>
                          <td><input type="radio" name="description-disp-check">表示</td>
                          <td>004a12x110-3451</td>
                          <td>メディア画像内の文言チェック</td>
                          <td>不可</td>
                          <td>エラー1101（学習が行われていません）</td>
                        </tr>  
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
                  <ul class="nav nav-pills nav-pills-icons nav-pills-info" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" href="#api-resex" role="tab" data-toggle="tab">
                        レスポンス例
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#api-auth" role="tab" data-toggle="tab">
                        資格情報
                      </a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#api-use" role="tab" data-toggle="tab">
                        利用方法
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content tab-space">
                    <div class="tab-pane active" id="api-resex">
                      <div class="highlight">
                        <p>レスポンスには、API-ID と 入力したテキスト 、 その識別結果が含まれています。以下に例を示します。</p>
<pre class="doc-content"><code class="language-html" data-lang="html">{
  "api_id": "00000-0000",
  "url": "https://cap.net/api/00000-0000",
  "status": "avairable",
  "request_text": "今日はいい天気ですね。",
  "response_top_class": "天気",
  "response_top_class_confidence": 0.95012345678912345
  "result": [
    {
      "class_name": "天気",
      "confidence": 0.95012345678912345
    },
    {
      "class_name": "気温",
      "confidence": 0.05987654321987654
    }
  ]
}</code></pre>
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