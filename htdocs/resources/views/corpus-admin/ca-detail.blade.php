@extends('layouts.corpus-admin.base')

@section('content')
<style>
  .table-striped button {
    padding: 3px;
  }
  .btnbox {
    width: 10%
  }
  .feather {
    width: 20px;
    height: 20px;
  }
  .table-striped th {
    text-align: center;
  }
  .table-striped td {
    padding: .35rem;
    vertical-align: middle;
    text-align: center;
  }
</style>
      <!--  コンテンツ  -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-2">
        <div class="panel-group mt-1">
          <div class="panel panel-default">
            <div class="panel-heading border-bottom mb-2">
              <h4 class="panel-title">
                <a data-toggle="collapse" href="#collapse1" style="text-decoration:none;">コーパス概要</a>
              </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse show">
              <div class="table-responsive">
                <table class="table mb-0">
                  <thead class="thead-light">
                    <tr>
                      <th scope="col"></th>
                      <th scope="col">内容</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <th scope="row">コーパス名</th>
                      <td>薬機法＆景表法の文言チェック</td>
                    </tr>
                    <tr>
                      <th scope="row">コーパス説明</th>
                      <td>クリエイティブが薬機法もしくは景表法に抵触する可能性の有無を分類する。</td>
                    </tr>
                    <tr>
                      <th scope="row">言語</th>
                      <td>日本語</td>
                    </tr>
                    <tr>
                      <th scope="row">有効化ステータス</th>
                      <td>有効</td>
                    </tr>
                    <tr>
                      <th scope="row">作成日</th>
                      <td>2018-06-01 12:00:00</td>
                    </tr>
                    <tr>
                      <th scope="row">最終更新日</th>
                      <td>2018-06-05 09:12:59</td>
                    </tr>
                  </tbody>
                </table>
                <div class="float-right">
                  <a href="/corpus/basic/edit/1">
                    <span class="text-muted" data-feather="settings" style="width:15px;height:15px;"></span>
                    <span class="text-muted">編集する</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="panel-group mt-4">
          <div class="panel panel-default">
            <div class="panel-heading border-bottom mb-2">
              <h4 class="panel-title">
                <a data-toggle="collapse" href="#collapse2" style="text-decoration:none;">稼動状況</a>
              </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse show">
              <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">有効化ステータス
                      <button type="button" class="btn btn-warning rounded-circle p-0 font-weight-bold text-white float-right" style="width:1.5rem;height:1.5rem;" data-toggle="modal" data-target="#aiSeidoModal">?</button>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">
                        <span data-feather="circle" class="text-danger font-weight-bold"></span>
                        <span class="h5 font-weight-bold">有効 <small>/ 無効</small></span>
                      </h5>
                      <p class="card-text">現在のステータスを表示しています。無効にすると、APIレスポンスを停止することができます。</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">学習進捗
                      <button type="button" class="btn btn-warning rounded-circle p-0 font-weight-bold text-white float-right" style="width:1.5rem;height:1.5rem;" data-toggle="modal" data-target="#hontekiModal">?</button>
                      <div class="modal fade" id="hontekiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">「本番適用」とは</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              入力された学習データをもとにコーパスが本番環境に適用され、AI判定結果をAPIサービスとして提供できる状態かどうかを表しています。<br>
                              「適用済み」の場合は、生成されたコーパスが本番適用されて、サービス提供可能な状態です。<br>
                              「検証中」の場合は、コーパスは作成されているがまだ本番適用されていない状態で、サービス提供できない状態です。<br>
                              「未適用」の場合は、コーパスが作成されておらず、サービス提供できない状態です。
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">
                        <span data-feather="circle" class="text-danger font-weight-bold"></span>
                        <span class="h5 font-weight-bold">完了 <small>/ 学習中 / 未学習</small></span>
                      </h5>
                      <p class="card-text">現在、ご利用可能な状態です。<br>ご利用方法は、<a href="/corpus/api-reference/1">API接続情報</a>をご確認ください。</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">教師データ量
                      <button type="button" class="btn btn-warning rounded-circle p-0 font-weight-bold text-white float-right" style="width:1.5rem;height:1.5rem;" data-toggle="modal" data-target="#trDataModal">?</button>
                      <div class="modal fade" id="trDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">「学習データ」とは</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              AIの判定結果を向上させるためにユーザによって登録されたデータセットのことです。<br>
                              学習データはコンマ区切り値 (CSV) フォーマット、もしくはコーパスのデータ管理画面から手動作成することができます。<br>
                              適切なAI分析結果を得るためには、充分な学習データが必要になります。詳細はデータ管理画面をご参照ください。
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title font-weight-bold">
                        <span data-feather="circle" class="text-danger font-weight-bold"></span>
                        <span class="h5 font-weight-bold">3200<small> 件</small>
                      </h5>
                      <p class="card-text">充分な量の学習データが登録されています。データの編集は<a href="/corpus/training/view/1">データ管理</a>で行ってください。</p>
                    </div>
                  </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                  <div class="card bg-light mb-3">
                    <div class="card-header">教師データの件数割合評価
                      <button type="button" class="btn btn-warning rounded-circle p-0 font-weight-bold text-white float-right" style="width:1.5rem;height:1.5rem;" data-toggle="modal" data-target="#aiThreadModal">?</button>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">
                        <span data-feather="alert-triangle" class="text-warning font-weight-bold"></span>
                        <span class="h5 font-weight-bold"><small>良い / </small>要確認<small> / 要調整</small></span>
                      </h5>
                      <p class="card-text">クラスごとのデータ件数がばらついているため、学習精度が低下している可能性があります。データの編集は、<a href="/corpus/training">データ管理</a>をご確認ください。</p>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                {{--  クラス別閾値  --}}
                <div class="col-lg-6 col-md-12 col-sm-12">
                  <div class="card bg-light mb-3">
                    <div class="card-header">クラス別閾値</div>
                    <div class="card-body">
                      <p>登録されている各クラスの判定閾値を表示しています。APIレスポンスでトップクラスの確信度がこの値を下回る場合、その判定は無効になります。</p>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">クラス名</th>
                            <th scope="col">データ件数</th>
                            <th scope="col">閾値</th>
                            <th class="btnbox"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>薬機法NG</td>
                            <td>500</td>
                            <td>0.8</td>
                            <td>
                              <button type="button" class="btn btn-secondary">
                                <span data-feather="edit-2" class="font-weight-bold"></span>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row">2</th>
                            <td>景表法NG</td>
                            <td>450</td>
                            <td>0.8</td>
                            <td>
                              <button type="button" class="btn btn-secondary">
                                <span data-feather="edit-2" class="font-weight-bold"></span>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row">3</th>
                            <td>その他NG</td>
                            <td>300</td>
                            <td>0.8</td>
                            <td>
                              <button type="button" class="btn btn-secondary">
                                <span data-feather="edit-2" class="font-weight-bold"></span>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row">4</th>
                            <td>薬機法OK</td>
                            <td>500</td>
                            <td>0.8</td>
                            <td>
                              <button type="button" class="btn btn-secondary">
                                <span data-feather="edit-2" class="font-weight-bold"></span>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row">5</th>
                            <td>景表法OK</td>
                            <td>50</td>
                            <td>0.8</td>
                            <td>
                              <button type="button" class="btn btn-secondary">
                                <span data-feather="edit-2" class="font-weight-bold"></span>
                              </button>
                            </td>
                          </tr>
                          <tr>
                            <th scope="row">6</th>
                            <td>その他OK</td>
                            <td>100</td>
                            <td>0.8</td>
                            <td>
                              <button type="button" class="btn btn-secondary">
                                <span data-feather="edit-2" class="font-weight-bold"></span>
                              </button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>

                <!-- 登録データ比率 -->
                <div class="col-lg-6 col-md-12 col-sm-12">
                  <div class="card bg-light mb-3">
                    <div class="card-header">クラス別登録データ比率</div>
                    <div class="card-body">
                      <h5 class="card-title">学習データ</h5>
                      <canvas id="prodDataChart" width="500" height="300"></canvas>
                    </div>
                  </div>
                </div>

              </div><!-- .row -->
            </div>
          </div>
        </div>
      </main>

      <!-- Graphs -->
      <script src="/js/chart.js"></script>
      <script>
        var ctx3 = document.getElementById("prodDataChart").getContext('2d');
        var myChart3 = new Chart(ctx3, {
          type: 'pie',
          data: {
            labels: ["薬機法NG", "景表法NG", "その他NG", "薬機法OK", "景表法OK", "その他OK"],
            datasets: [{
              backgroundColor: [
                "#2ecc71",
                "#3498db",
                "#95a5a6",
                "#9b59b6",
                "#f1c40f",
                "#e74c3c"
              ],
              data: [500, 450, 300, 500, 50, 100]
            }]
          }
        });

      </script>
@endsection