@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span> 
  サービス管理
@endsection

@section('content')
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
            <div class="col-md-12 col-lg-6">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title ">管理アカウント一覧</h4>
                  <p class="card-category"> 本サイトを閲覧できるアカウントの一覧です。</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-info">
                        <th>氏名</th>
                        <th>登録メール</th>
                        <th>ステータス</th>
                        <th></th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>管理 太郎</td>
                          <td>admin@test.com</td>
                          <td>有効</td>
                          <td>
                            <button type="button" rel="tooltip" class="btn btn-success" onclick="location.href='/acount/edit/1'">
                              <i class="material-icons">edit</i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                              <i class="material-icons">close</i>
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">本当に削除してもよろしいですか？</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  実行すると当該アカウントのプロフィール情報は全て削除されます。
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                  <button type="button" class="btn btn-primary">削除</button>
                                </div>
                                </div>
                              </div>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td>管理 太郎2</td>
                          <td>admin2@test.com</td>
                          <td>有効</td>
                          <td>
                            <button type="button" rel="tooltip" class="btn btn-success" onclick="location.href='/acount/edit/1'">
                              <i class="material-icons">edit</i>
                            </button>
                            <button type="button" rel="tooltip" class="btn btn-danger">
                              <i class="material-icons">close</i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <button type="button" class="btn btn-info">新規登録</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title">サービス上限設定</h4>
                  <p class="card-category">各種サービスの上限実行回数です。</p>
                </div>
                <div class="card-body">
                  <div class="limit-contents">
                    <table class="table">
                      <thead class=" text-info">
                        <th>サービス</th>
                        <th>上限回数</th>
                        <th></th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>APIコール回数</td>
                          <td>10,000　回</td>
                          <td>
                            <button type="button" rel="tooltip" class="btn btn-success" onclick="location.href='/acount/edit/1'">
                              <i class="material-icons">edit</i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">本当に削除してもよろしいですか？</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  実行すると当該アカウントのプロフィール情報は全て削除されます。
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                                  <button type="button" class="btn btn-primary">削除</button>
                                </div>
                                </div>
                              </div>
                            </div>
                          </td>
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
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title ">利用ログ一覧</h4>
                  <p class="card-category">ユーザーが本サイトを閲覧、利用した履歴の一覧です。</p>
                </div>
                <div class="card-body">
                  <div class="limit-contents">
                    <table class="table">
                      <thead class=" text-info">
                        <th>日時</th>
                        <th>利用者</th>
                        <th>レベル</th>
                        <th>内容</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>2018-06-01 12:45:00</td>
                          <td>ユーザー(157.12.16.150)</td>
                          <td>エラー</td>
                          <td>API-ID:0adfwjf98-7786 は現在無効になっているため応答できません。</td>
                        </tr>
                        <tr>
                          <td>2018-06-01 12:45:00</td>
                          <td>テスト太郎</td>
                          <td>エラー</td>
                          <td>コーパスID:0teg38aq は検証用の教師データが登録されていないため検証できません。</td>
                        </tr>
                        <tr>
                          <td>2018-06-01 12:15:00</td>
                          <td>テスト太郎</td>
                          <td>警告</td>
                          <td>コーパスID:0teg38aq が作成されましたが、教師データが登録されていません。</td>
                        </tr>
                        <tr>
                          <td>2018-06-01 12:00:00</td>
                          <td>テスト太郎</td>
                          <td>情報</td>
                          <td>ログインしました。</td>
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
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title ">ご請求一覧</h4>
                  <p class="card-category">ご請求利用料金の履歴の一覧です。</p>
                </div>
                <div class="card-body">
                  <div class="limit-contents">
                    <table class="table">
                      <thead class=" text-info">
                        <th>＃</th>
                        <th>対象年月</th>
                        <th>APIコール回数</th>
                        <th>利用料金</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>2018年6月分</td>
                          <td>23,200</td>
                          <td>￥81,000</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>2018年5月分</td>
                          <td>21,192</td>
                          <td>￥73,000</td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>2018年4月分</td>
                          <td>19,000</td>
                          <td>￥55,000</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection