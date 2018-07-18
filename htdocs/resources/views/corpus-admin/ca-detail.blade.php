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
        @if(Session::has('success_msg'))
        <div class="alert alert-success" role="alert">
          {{ session('success_msg') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif

        @if(Session::has('error_msg'))
        <div class="alert alert-danger" role="alert">
          {{ session('error_msg') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif


        @if(count($errors) > 0)
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul style="margin-bottom: 0;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
          </ul>
        </div>
        @endif


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
                      <td>{{ $corpus->name }}</td>
                    </tr>
                    <tr>
                      <th scope="row">コーパス説明</th>
                      <td>{!! nl2br(e($corpus->description)) !!}</td>
                    </tr>
                    <tr>
                      <th scope="row">言語</th>
                      <td>{{\App\Enums\ClassifierLanguage::getJapaneseDescription($corpus->language)}}</td>
                    </tr>
                    <tr>
                      <th scope="row">作成日</th>
                      <td>{{ $corpus->created_at }}</td>
                    </tr>
                    <tr>
                      <th scope="row">最終更新日</th>
                      <td>{{ $corpus->updated_at }}</td>
                    </tr>
                  </tbody>
                </table>
                <div class="float-right">
                  <a href="javascript:void(0);">
                    <span class="text-muted" data-feather="settings" style="width:15px;height:15px;"></span>
                    <span class="text-muted" data-toggle="modal" data-target="#editCorpusModal">編集する</span>
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


      <!-- コーパス編集 -->
      <div class="modal fade" id="editCorpusModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="/corpus/edit" method="post" class="needs-validation" id="edit-corpus-form">
              {{ csrf_field() }}
              <div class="modal-header">
                <h5 class="modal-title">コーパスの編集</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p><small>コーパスを作成し教師データを学習することで、ユーザから入力されたクリエイティブの意図を分類し、結果をAPIとして提供できます。</small></p>

                <div class="default-form-area mt-4">
                  <div class="form-group">
                    <label for="editCorpusName">コーパス名</label>
                    <input type="text" name="name" value="{{ $corpus->name }}" class="form-control" id="editCorpusName" aria-describedby="nameHelp" required>
                    <small id="nameHelp" class="form-text text-muted">10字程度の識別しやすい名前を記入してください。</small>
                    <div class="invalid-feedback">
                      コーパス名を入力してください
                    </div>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label for="editDescription">説明文</label>
                    <textarea name="description" class="form-control" id="editDescription" rows="3" required>{{ $corpus->description }}</textarea>
                    <!-- <small class="form-text text-muted">1000文字以内で入力してください。</small> -->
                    <div class="invalid-feedback">
                      説明文を入力してください
                    </div>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label for="selectClass">言語</label>
                    <select name="language" class="form-control form-control-sm" id="selectClass">
                    @foreach($language_list as $index => $language)
                      @if($corpus->language == $language['value'])
                      <option value="{{ $language['value'] }}" selected>{{ $language['label'] }}</option>
                      @else
                      <option value="{{ $language['value'] }}">{{ $language['label'] }}</option>
                      @endif
                    @endforeach
                    </select>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.default-form-area -->

              </div>
              <!-- /.modal-body -->
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="add_content_btn">編集する</button>
                <input type="hidden" name="corpus_id" value="{{ $corpus->id }}">
              </div>
              <!-- /.modal-footer -->
            </form>
            <!-- /form -->
          </div>
          <!-- /.modal-content -->
        </div>
      </div>
      <!-- /学習データ追加Modal -->
@endsection