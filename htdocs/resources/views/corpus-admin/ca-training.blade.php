@extends('layouts.corpus-admin.base')

@section('content')
      <style>
        p {
          margin-bottom: 0;
        }
        .step-list__line {
          border-bottom: 1px solid #DDD;
        }
        .step-list__line:first-child {
          border-top: 1px solid #DDD;
        }
        .step-list__cell {
          padding-top: 10px;
          padding-right: 10px;
          vertical-align: top;
        }
        .step-list__down--blue .step-list__rect {
          background-color: #3498db;
        }
        .step-list__down--blue .step-list__tri {
          border-top: 15px solid #3498db;
        }
        .step-list__down--red .step-list__rect {
          background-color: #c0392b;
        }
        .step-list__down--red .step-list__tri {
          border-top: 15px solid #c0392b;
        }
        .step-list__down--yellow .step-list__rect {
          background-color: #f39c12;
        }
        .step-list__down--yellow .step-list__tri {
          border-top: 15px solid #f39c12;
        }
        .step-list__rect {
          width: 60px;
          height: 45px;
          background-color: #3498db;
          -moz-border-radius: 3px 3px 0 0;
          -webkit-border-radius: 3px;
          border-radius: 3px 3px 0 0;
          color: white;
          text-align: center;
          font-weight: bold;
          padding: 10px;
          font-size: 24px;
          letter-spacing: 0.1em;
        }
        .step-list__tri {
          width: 0;
          height: 0;
          border-right: 30px solid transparent;
          border-bottom: 5px solid transparent;
          border-left: 30px solid transparent;
        }
        .step-list__heading {
          font-weight: bold;
          margin-bottom: 10px;
        }
        .step-list__text {
          font-size: 0.95rem;
          color: dimgray;
        }
        .card-body {
          padding: 0.9rem;
        }
        .step-list__line:first-child {
          border-top: none;
        }
      </style>
      <!--  コンテンツ  -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-2">
        <section>
          <div class="row">
            {{-- 学習ステップ  --}}
            <div class="col-7">
              <h4>学習ステップ</h4>
              <div class="card bg-light mb-3">
                <div class="card-body">
                  <table class="step-list">
                    <tr class="step-list__line">
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.45;">
                          <div class="step-list__rect">
                            01
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          教師データの準備
                        </h4>
                        <p class="step-list__text">
                          AIコーパスの作成に必要な教師データを準備します。
                        </p>
                      </td>
                    </tr>

                    <tr class="step-list__line">
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.55;">
                          <div class="step-list__rect">
                            02
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          教師データの登録
                        </h4>
                        <p class="step-list__text">
                          データ管理画面から教師データを登録できます。
                        </p>
                      </td>
                    </tr>

                    <tr class="step-list__line">
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.65;">
                          <div class="step-list__rect">
                            03
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <div class="row">
                          <div class="col-7">
                            <h4 class="step-list__heading">
                              AI判定確信度の閾値設定
                            </h4>
                            <p class="step-list__text">
                              登録された教師データを基にAI学習を行います。
                            </p>
                          </div>
                          <div class="col-2" style="margin-top:10px;">
                            <span class="text-muted" data-feather="chevrons-right" style="width:85%;height:65%;"></span>
                          </div>
                          <div class="col-3">
                            <p class="step-list__text">
                              <button type="button" class="btn btn-link btn-lg">閾値設定</button>
                            </p>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr class="step-list__line">
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.75;">
                          <div class="step-list__rect">
                            04
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <div class="row">
                          <div class="col-7">
                            <h4 class="step-list__heading">
                              AI学習の実行
                            </h4>
                            <p class="step-list__text">
                              登録された教師データを基にAI学習を行います。
                            </p>
                          </div>
                          <div class="col-2" style="margin-top:10px;">
                            <span class="text-muted" data-feather="chevrons-right" style="width:85%;height:65%;"></span>
                          </div>
                          <div class="col-3">
                            <p class="step-list__text">
                              <span class="text-danger">実行可能</span>
                              <button type="button" class="btn btn-danger btn-lg">学習の実行</button>
                            </p>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr class="step-list__line">
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.85;">
                          <div class="step-list__rect">
                            05
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <div class="row">
                          <div class="col-7">
                            <h4 class="step-list__heading">
                              AI学習結果の検証
                            </h4>
                            <p class="step-list__text">
                              検証用データを基に、学習結果を検証できます。
                            </p>
                          </div>
                          <div class="col-2" style="margin-top:10px;">
                            <span class="text-muted" data-feather="chevrons-right" style="width:85%;height:65%;"></span>
                          </div>
                          <div class="col-3">
                            <p class="step-list__text">
                              <button type="button" class="btn btn-danger btn-lg">結果の確認</button>
                            </p>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr class="step-list__line">
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.90;">
                          <div class="step-list__rect">
                            06
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <div class="row">
                          <div class="col-7">
                            <h4 class="step-list__heading">
                              教師データのメンテナンス
                            </h4>
                            <p class="step-list__text">
                              検証用データを基に、学習結果を検証できます。
                            </p>
                          </div>
                          <div class="col-2" style="margin-top:10px;">
                            <span class="text-muted" data-feather="chevrons-right" style="width:85%;height:65%;"></span>
                          </div>
                          <div class="col-3">
                            <p class="step-list__text">
                              <button type="button" class="btn btn-link btn-lg">データ登録</button>
                            </p>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr class="step-list__line">
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 1;">
                          <div class="step-list__rect">
                            07
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <div class="row">
                          <div class="col-7">
                            <h4 class="step-list__heading">
                              AI学習結果の検証
                            </h4>
                            <p class="step-list__text">
                              検証用データを基に、学習結果を検証できます。
                            </p>
                          </div>
                          <div class="col-2" style="margin-top:10px;">
                            <span class="text-muted" data-feather="chevrons-right" style="width:85%;height:65%;"></span>
                          </div>
                          <div class="col-3">
                            <p class="step-list__text">
                              <button type="button" class="btn btn-danger btn-lg">結果の確認</button>
                            </p>
                          </div>
                        </div>
                      </td>
                    </tr>

                  </table>
                </div><!-- .card-body -->
              </div><!-- .card -->
            </div>

            <div class="col-5" style="border-left:solid 1px lightgray;">
              <h4>これまでの学習状況</h4>
              <div class="row">
                {{--  カード1  --}}
                <div class="col-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">
                      未学習データの有無
                    </div>
                    <div class="card-body" style="width:100%;clear:both;">
                      <div style="float:left;width:35%;text-align:center;">
                        <span class="text-danger" data-feather="alert-triangle" style="width:60%;height:60%;"></span>
                        <p style="margin:0;color:indianred;font-weight:bold;">あり</p>
                      </div>
                      <div style="float:right;width:65%;">
                        <p>学習が完了していないデータがあります。</p>
                      </div>
                    </div>
                  </div>
                </div>
                {{--  カード2  --}}
                <div class="col-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">
                      未検証データの有無
                    </div>
                    <div class="card-body" style="width:100%;clear:both;">
                      <div style="float:left;width:35%;text-align:center;">
                        <span class="text-success" data-feather="check" style="width:60%;height:60%;"></span>
                        <p style="margin:0;color:limegreen;font-weight:bold;">なし</p>
                      </div>
                      <div style="float:right;width:65%;">
                        <p>すべての検証用データは検証済みです。</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                {{--  カード3  --}}
                <div class="col-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">
                      累計学習回数
                    </div>
                    <div class="card-body" style="width:100%;">
                      <p class="mb-0" style="text-align:center;font-weight:bold;font-size:2.5rem;color:dimgray;">10
                        <small class="" style="font-size:1.5rem;">回</small></p>
                      <div style="">
                        <span>最終学習日時</span>
                        <span>2018/05/01 12:00:00</span>
                      </div>
                    </div>
                  </div>
                </div>
                {{--  カード4  --}}
                <div class="col-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">
                      累計検証回数
                    </div>
                    <div class="card-body" style="width:100%;">
                      <p class="mb-0" style="text-align:center;font-weight:bold;font-size:2.5rem;color:dimgray;">7
                        <small class="" style="font-size:1.5rem;">回</small></p>
                      <div style="">
                        <span>最終検証日時</span>
                        <span>2018/05/03 14:10:30</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                {{--  学習結果棒グラフ  --}}
                <div class="col-12">
                  <div class="card bg-light mb-3">
                    <div class="card-header">最新の検証結果サマリー（2018/05/01 12:00:00時点）</div>
                    <div class="card-body" style="padding: 0.5rem;">
                      <canvas id="myBarChart" width="700" height="350"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </main>

      <!-- Graphs -->
      <script src="/js/chart.js"></script>
      <script>
        //棒グラフ
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
          type: 'horizontalBar',
          data: {
            labels: ["景表法NG", "薬機法NG", "その他NG", "景表法OK", "薬機法OK", "その他OK"],
            datasets: [
              {
                label: "適合率[%]",
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                data: [89, 90, 85, 81, 92, 90]
              },
              {
                label: "再現率[%]",
                backgroundColor: "rgba(255,127,80,0.4)",
                borderColor: "rgba(255,127,80,1)",
                data: [93, 79, 81, 80, 89, 91]
              }  
            ]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                }
              }]
            }
          }
        });
      </script>
@endsection