@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span> 
  サービス管理
@endsection

@section('content')
<style>
  .setting-table .btnbox {
    width: 20%;
  }
  .setting-table button {
    padding: 5px;
  }

  .warning-notify {
    margin-bottom: 0; 
    line-height: 1.5;
  }

</style>
      <div class="content">
        <div class="container-fluid">
          <div class="row">

          @if (session('msg') || count($errors) > 0)
            <script>
              //   type = ['', 'info', 'danger','success', 'warning', 'rose', 'primary'];
              //   color = Math.floor((Math.random() * 6) + 1);
              function showAlert(msg, type) {
                $.notify({
                  icon: "notifications",
                  message: msg

                }, {
                  type: type,
                  timer: 1000,
                  placement: {
                    from: 'top',
                    align: 'center'
                  }
                });
              }

            @if(session('msg')) 
              showAlert('{{ session("msg") }}', 'success');
            @endif

            @if(count($errors) > 0)
              // error_msg = '<ul style="margin-bottom: 0;">';
              error_msg = '<p class="warning-notify">';
              @foreach($errors->all() as $error)
                error_msg += '{{ $error }}<br>';
              @endforeach
              error_msg += '</p>';

              showAlert(error_msg, 'warning');
            @endif
              
            </script>
          @endif

            <div class="col-md-12 col-lg-6">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title ">管理アカウント一覧</h4>
                  <p class="card-category"> 本サイトを閲覧できるアカウントの一覧です。</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">

                  @if(count($users) === 0) 
                  <div class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <i class="material-icons">close</i>
                    </button>
                    <span>登録されているユーザは存在しません</span>
                  </div>

                  @else
                    <table class="table setting-table">
                      <thead class=" text-info">
                        <th>氏名</th>
                        <th>登録メール</th>
                        <th class="btnbox"></th>
                      </thead>
                      <tbody>
                    @foreach($users as $user)
                        <tr>
                          <td>{{ $user->sei_kanji }} {{ $user->mei_kanji }}</td>
                          <td>{{ $user->email }}</td>
                          <td>
                            <button type="button" rel="tooltip" class="btn btn-success" data-toggle="modal" data-target="#editUserModal"
                              data-edit-user="{{ $user->id }}" data-sei-kanji="{{ $user->sei_kanji }}" data-mei-kanji="{{ $user->mei_kanji }}" data-email="{{ $user->email }}">
                              <i class="material-icons">edit</i>
                            </button>
                      @if($user->id !== $my_user_id)
                            <button type="button" rel="tooltip" class="btn btn-danger" data-toggle="modal" data-target="#deleteUserModal"
                              data-delete-user="{{ $user->id }}">
                              <i class="material-icons">close</i>
                            </button>
                      @endif
                          </td>
                        </tr>
                    @endforeach
                      </tbody>
                    </table>
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addUserModal">新規登録</button>
                  @endif
                  </div>
                </div>
              </div>
            </div>
            <!-- /.col -->

            <div class="col-md-12 col-lg-6">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title">月間APIコール上限設定</h4>
                  <p class="card-category">
                    
                  </p>
                </div>
                <div class="card-body">
                  <div class="limit-contents">
                    <table class="table setting-table">
                      <thead class=" text-info">
                        <th>サービス</th>
                        <th>上限回数</th>
                        <th class="btnbox"></th>
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
          <!-- /.row -->

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
                          <td>ログインしました。[GET / HTTP/1.1 Chrome/66.0.3359.181 10.171.2.123:38981]</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->

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
          <!-- /.row -->

        </div>
      </div>
      <!-- /.content -->


      <!-- モーダル群 -->

      <!-- ユーザ追加モーダル -->
      <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="/settings/user/register" method="post" id="add-user-form">
              {{ csrf_field() }}

              <div class="modal-header">
                <h5 class="modal-title">アカウントの新規作成</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- /.modal-header -->
              <div class="modal-body">
              
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="addSeiKanjiField" class="bmd-label-floating">姓</label>
                      <input type="text" class="form-control" name="sei_kanji" id="addSeiKanjiField" required>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->

                  <div class="col">
                    <div class="form-group">
                      <label for="addMeiKanjiField" class="bmd-label-floating">名</label>
                      <input type="text" class="form-control" name="mei_kanji" id="addMeiKanjiField" required>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="addEmailField" class="bmd-label-floating">メールアドレス</label>
                      <input type="email" class="form-control" name="email" id="addEmailField" required>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="addPasswordField" class="bmd-label-floating">パスワード</label>
                      <input type="password" class="form-control" name="password" id="addPasswordField" aria-describedby="addPwHelp" minlength="6" required>
                      <small id="addPwHelp" class="form-text text-muted">パスワードは6文字以上で指定してください</small>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                
              </div>
              <!-- /.modal-body -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                <button type="submit" class="btn btn-brand">登録</button>
              </div>
              <!-- /.modal-footer -->
            </form>
            <!-- /form -->
          </div>
          <!-- /.modal-content -->
        </div>
      </div>
      <!-- /ユーザ追加モーダル -->


      <!-- ユーザ編集モーダル -->
      <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="/settings/user/edit" method="post" id="edit-user-form">
              {{ csrf_field() }}

              <div class="modal-header">
                <h5 class="modal-title">アカウントの編集</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- /.modal-header -->
              <div class="modal-body">
              
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="editSeiKanjiField" class="bmd-label-floating">姓</label>
                      <input type="text" class="form-control" name="sei_kanji" id="editSeiKanjiField" required>
                      <span class="material-icons form-control-feedback">
                        <i class="material-icons">clear</i>
                      </span>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->

                  <div class="col">
                    <div class="form-group">
                      <label for="editMeiKanjiField" class="bmd-label-floating">名</label>
                      <input type="text" class="form-control" name="mei_kanji" id="editMeiKanjiField" required>
                      <span class="material-icons form-control-feedback">
                        <i class="material-icons">clear</i>
                      </span>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="editEmailField" class="bmd-label-floating">メールアドレス</label>
                      <input type="email" class="form-control" name="email" id="editEmailField" required>
                      <span class="material-icons form-control-feedback">
                        <i class="material-icons">clear</i>
                      </span>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <label for="editPasswordField" class="bmd-label-floating">パスワード（変更する場合は入力してください）</label>
                      <input type="password" class="form-control" name="password" id="editPasswordField" minlength="6" aria-describedby="editPwHelp">
                      <small id="editPwHelp" class="form-text text-muted">パスワードは6文字以上で指定してください</small>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                
              </div>
              <!-- /.modal-body -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                <button type="submit" class="btn btn-brand" id="editSubmitBtn">編集</button>
                <input type="hidden" name="edit_user_id" id="editUserId">
              </div>
              <!-- /.modal-footer -->
            </form>
            <!-- /form -->
          </div>
          <!-- /.modal-content -->
        </div>
      </div>
      <!-- /ユーザ編集モーダル -->


      <!-- ユーザ削除モーダル -->
      <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form action="/settings/user/delete" method="post">
              {{ csrf_field() }}

              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">本当に削除してもよろしいですか？</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <!-- /.modal-header -->
              <div class="modal-body">
                実行すると当該アカウントのプロフィール情報は全て削除されます。
              </div>
              <!-- /.modal-body -->
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                <button type="submit" class="btn btn-danger">削除</button>
                <input type="hidden" name="delete_user_id" id="deleteUserId">
              </div>
              <!-- /.modal-footer -->
            </form>
          </div>
        </div>
      </div>
      <!-- /ユーザ削除モーダル -->
@endsection

@section('page-js')
  <script src="{{ mix('/js/main/dashboard/settings.js') }}"></script>
@endsection