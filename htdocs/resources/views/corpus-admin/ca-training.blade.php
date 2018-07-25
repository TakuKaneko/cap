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
          padding-bottom: 5px;
          padding-right: 10px;
          vertical-align: middle;
        }
        .step-list__cell .row {
          max-height: 70px;
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
        .text-align-center {
          text-align: center;
        }
        .text-align-left {
          text-align: left;
        }
        .mt-15 {
          margin-top: 15px;
        }
        .form_threshold {
          width: 70%;
          margin: 15px auto 0 auto;
        }
        .col-form-label {
          text-align: right;
          font-weight: bold;
          
        }
      </style>
      <!--  コンテンツ  -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-2">
      @if (session('msg'))
        <script>
          alert('{{ session("msg") }}');
        </script>
      @endif

        <section>
          <div class="row">
            {{-- 学習ステップ  --}}
            <div class="col-8">
              <h4>学習ステップ</h4>
              <div class="card bg-light mb-3">
                <div class="card-body">
                  <table class="step-list">

                    <tr class="step-list__line"><!-- 01教師データ登録 -->
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.35;">
                          <div class="step-list__rect">
                            01
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          教師データの登録
                        </h4>
                        <p class="step-list__text">
                          学習/テストデータをシステム登録します。
                        </p>
                      </td>
                      <td class="step-list__cell">
                        <span class="text-muted" data-feather="chevrons-right" style=""></span>
                      </td>
                      <td class="step-list__cell">
                        <button type="button" class="btn btn-link" onclick="location.href='/corpus/data/view/{{ $corpus->id }}'">データ管理画面へ</button>
                      </td>
                    </tr>

                    <tr class="step-list__line"><!-- 02学習実行 -->
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.45;">
                          <div class="step-list__rect">
                            02
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          AI学習の実行
                        </h4>
                        <p class="step-list__text">
                          学習データを元にAI学習を行います。
                        </p>
                      </td>
                      <td class="step-list__cell">
                        <span class="text-muted" data-feather="chevrons-right" style=""></span>
                      </td>
                      <td class="step-list__cell">
                        <!-- <small class="mt-15">実行可能</small><br> -->
                        @if($step_training_status['can_training'])
                          <!-- <button type="button" class="btn btn-danger">学習実行</button> -->
                          @if($training_status['can_training'])
                          <p class="text-danger">{{ $step_training_status['message'] }}</p>
                          <a href="/corpus/training/exec/{{ $corpus->id }}" class="btn btn-danger">学習実行</a>
                          @else
                          <p class="text-secondary">{{ $training_status['training_data_status'] }}</p>
                          <button type="button" class="btn btn-secondary" disabled>実行不可</button>
                          @endif
                        @else
                          <p class="text-secondary">{{ $step_training_status['message'] }}</p>
                          <button type="button" class="btn btn-secondary" disabled>実行不可</button>
                        @endif
                      </td>
                    </tr>

                    <tr class="step-list__line"><!-- 03レポート -->
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.55;">
                          <div class="step-list__rect">
                            03
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          AI学習結果のテスト<small>（任意）</small>
                        </h4>
                        <p class="step-list__text">
                          テストデータを元にAIの回答精度を確認します。
                        </p>
                      </td>
                      <td class="step-list__cell">
                        <span class="text-muted" data-feather="chevrons-right" style=""></span>
                      </td>
                      <td class="step-list__cell">
                        @if ($step_training_status['can_test'])
                          <p class="text-danger">実行可能</p>
                          <button type="button" class="btn btn-outline-danger">テスト実行</button>
                        @else
                          <!-- <p class="text-secondary">実行不可</p> -->
                          <button type="button" class="btn btn-secondary" disabled>実行不可</button>
                        @endif
                      </td>
                    </tr>

                    <tr class="step-list__line"><!-- 04テスト実行 -->
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.65;">
                          <div class="step-list__rect">
                            04
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          AI回答の個別検証<small>（任意）</small>
                        </h4>
                        <p class="step-list__text">
                          検証したいテキストを個別に入力し、回答内容を確認します。
                        </p>
                      </td>
                      <td class="step-list__cell">
                        <span class="text-muted" data-feather="chevrons-right" style=""></span>
                      </td>
                      <td class="step-list__cell">
                        @if ($step_training_status['can_test'])
                          <p class="text-danger">実行可能</p>
                          <button type="button" class="btn btn-outline-danger">検証実行</button>
                        @else
                          <!-- <p class="text-secondary">実行不可</p> -->
                          <button type="button" class="btn btn-secondary" disabled>実行不可</button>
                        @endif
                      </td>
                    </tr>

                    <tr class="step-list__line"><!-- 05教師データ修正 -->
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.75;">
                          <div class="step-list__rect">
                            05
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          学習データの修正<small>（任意）</small>
                        </h4>
                        <p class="step-list__text">
                          学習データを修正し回答精度を改善します。
                        </p>
                      </td>
                      <td class="step-list__cell">
                        <span class="text-muted" data-feather="chevrons-right" style=""></span>
                      </td>
                      <td class="step-list__cell">
                        <button type="button" class="btn btn-link">データ管理画面へ</button>
                      </td>
                    </tr>

                    <tr class="step-list__line"><!-- 06閾値設定 -->
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 0.85;">
                          <div class="step-list__rect">
                            06
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          AI判定の閾値設定<small>（任意）</small>
                        </h4>
                        <p class="step-list__text">
                          AI判定の基準となる確信度の閾値を設定します。
                        </p>
                      </td>
                      <td class="step-list__cell">
                        <span class="text-muted" data-feather="chevrons-right" style=""></span>
                      </td>
                      <td class="step-list__cell">
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#shikiichiModal">閾値設定</button>
                        <div class="modal fade" id="shikiichiModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalLongTitle">確信度の閾値設定</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <p>
                                  閾値を設定することで、AI判定の精度を調整することができます。<br>
                                  閾値は、0 ～ 1 の範囲で設定でき、確信度（confidence）が閾値以上の場合に判定結果（passed_classes）として出力されます。<br>
                                  以下フォームに閾値を入力してください。 例）0.5、0.8123
                                </p>
                                <form action="/corpus/1/threshold/setting" method="POST" name="form_threshold" class="form_threshold mt-15">
                                  <div class="form-group row">
                                    <label for="threshold_class_all" class="col-5 col-form-label" style="color:darkblue;padding-top:25px;">
                                      共通<br>
                                    </label>
                                    <div class="col-5">
                                      <span class="text-secondary" style="font-size:0.8rem;">全クラスの初期値として設定されます。</span>
                                      <input type="text" class="form-control" id="threshold_class_1" placeholder="閾値を入力">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="threshold_class_1" class="col-5 col-form-label">景表法NG</label>
                                    <div class="col-5">
                                      <input type="text" class="form-control" id="threshold_class_1" placeholder="閾値を入力">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <label for="threshold_class_1" class="col-5 col-form-label">薬機法NG</label>
                                    <div class="col-5">
                                      <input type="text" class="form-control" id="threshold_class_1" placeholder="閾値を入力">
                                    </div>
                                  </div>
                                  <div class="form-group row">
                                    <div class="col-12 text-align-center">
                                      <button type="submit" class="btn btn-primary" style="width:70px;">保存</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>

                    <tr class="step-list__line"><!-- 07本番反映 -->
                      <td class="step-list__cell">
                        <div class="step-list__down step-list__down--blue" style="opacity: 1;">
                          <div class="step-list__rect">
                            07
                          </div>
                          <div class="step-list__tri"></div>
                        </div>
                      </td>
                      <td class="step-list__cell">
                        <h4 class="step-list__heading">
                          本番反映
                        </h4>
                        <p class="step-list__text">
                          学習済みコーパスを本番で運用開始します。
                        </p>
                      </td>
                      <td class="step-list__cell">
                        <span class="text-muted" data-feather="chevrons-right" style=""></span>
                      </td>
                      <td class="step-list__cell">
                        @if ($step_training_status['number'] == '4')
                          <p class="text-danger">実行可能</p>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#honbanModal">本番反映</button>
                          <div class="modal fade" id="honbanModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="modalLongTitle">本番反映の確認</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <p>
                                    本番反映を行うことで、このコーパスがご利用中のAPIに紐付き、AI審査が行われるようになります。<br>
                                    現在APIに紐づいているコーパスは「検証用」に切り替わり、このコーパスが「本番用」として利用開始されます。<br>
                                    紐付けるAPIを指定して「本番用」に切り替えてください。
                                  </p>
                                  <form action="/corpus/training/activate/{{ $corpus->id }}" method="POST" name="form_select_api" class="form_threshold mt-15">
                                    {{ csrf_field() }}
                                    <div class="form-group row">
                                      <p class="font-weight-bold">紐付けるAPIを指定してください：</p>
                                      <!-- <div class="col-5"> -->
                                        <select class="form-control" id="select_api" name="select_api">
                                          @foreach ($api_list as $api)
                                            <option value="{{ $api->id }}">{{ $api->name }}</option>
                                          @endforeach
                                        </select>
                                      <!-- </div> -->
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-12 text-align-center">
                                        <button type="submit" class="btn btn-danger mr-3" style="">切り替え</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">閉じる</button>
                                      </div>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        @else
                          <button type="button" class="btn btn-secondary" disabled>実行不可</button>
                        @endif
                      </td>
                    </tr>

                  </table>
                </div><!-- .card-body -->
              </div><!-- .card -->
            </div>

            <div class="col-4 text-align-center" style="border-left:solid 1px lightgray;">
              <h4 class="text-align-left">これまでの学習状況</h4>
              <!-- <div class="row">
                {{--  カード1  --}}
                <div class="col-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">
                      学習データ
                    </div>
                    <div class="card-body">
                    @if($training_status['training_data_status'] === App\Enums\TrainingDataStatus::NoData || $training_status['training_data_status'] === App\Enums\TrainingDataStatus::DataDeficiencies || $training_status['training_data_status'] === App\Enums\TrainingDataStatus::ExistUntrainingData )
                      <span class="text-danger" data-feather="alert-triangle" style="width:40px;height:40px;"></span>
                      <p style="margin:0;color:indianred;font-weight:bold;">{{ $training_status['training_data_status'] }}</p>
                    @else
                      <span class="text-success" data-feather="check" style="width:40px;height:40px;"></span>
                      <p style="margin:0;color:limegreen;font-weight:bold;">{{ $training_status['training_data_status'] }}</p>
                    @endif
                      
                    </div>

                  </div>
                </div>
                {{--  カード2  --}}
                <div class="col-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">
                      未検証データ
                    </div>
                    <div class="card-body">
                      <span class="text-success" data-feather="check" style="width:40px;height:40px;"></span>
                      <p style="margin:0;color:limegreen;font-weight:bold;">なし</p>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="row">
                {{--  カード3  --}}
                <div class="col-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">
                      累計学習回数
                    </div>
                    <div class="card-body" style="width:100%;">
                      <p class="mb-0" style="text-align:center;font-weight:bold;font-size:2.5rem;color:dimgray;">
                        10<small class="" style="font-size:1.5rem;">回</small>
                      </p>
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
                      <p class="mb-0" style="text-align:center;font-weight:bold;font-size:2.5rem;color:dimgray;">
                        7<small class="" style="font-size:1.5rem;">回</small>
                      </p>
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="row">
                {{--  学習結果棒グラフ  --}}
                <div class="col-12">
                  <div class="card bg-light mb-3">
                    <div class="card-header">最新の検証結果サマリー<br>（2018/05/01 12:00:00時点）</div>
                    <div class="card-body" style="padding: 0.5rem;">
                      <canvas id="myBarChart" width="200" height="200"></canvas>
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