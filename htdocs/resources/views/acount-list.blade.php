@extends('layouts.base')

@section('title')
  <a href="{{ url('/') }}">TOP</a> <span style="margin: 0 5px;"> ＞ </span> 管理アカウント一覧
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
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-header card-header-default">
                                    <h4 class="card-title ">管理アカウント一覧</h4>
                                    <p class="card-category"> 本サイトを閲覧できるアカウントの一覧です。</p>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class=" text-primary">
                                                <th>No</th>
                                                <th>氏名</th>
                                                <th>登録メール</th>
                                                <th>ステータス</th>
                                                <th></th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>管理 太郎</td>
                                                    <td>admin@test.com</td>
                                                    <td>有効</td>
                                                    <td>
                                                        <button type="button" rel="tooltip" class="btn btn-simple" onclick="location.href='/acount/edit/1'">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-simple"  data-toggle="modal" data-target="#exampleModal">
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
                                                    <td>2</td>
                                                    <td>管理 太郎2</td>
                                                    <td>admin2@test.com</td>
                                                    <td>有効</td>
                                                    <td>
                                                        <button type="button" rel="tooltip" class="btn btn-simple" onclick="location.href='/acount/edit/1'">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-simple">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>管理 太郎3</td>
                                                    <td>admin@test.com</td>
                                                    <td>有効</td>
                                                    <td>
                                                        <button type="button" rel="tooltip" class="btn btn-simple" onclick="location.href='/acount/edit/1'">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-simple">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>管理 太郎4</td>
                                                    <td>admin4@test.com</td>
                                                    <td>無効</td>
                                                    <td>
                                                        <button type="button" rel="tooltip" class="btn btn-simple" onclick="location.href='/acount/edit/1'">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-simple">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-danger">新規登録</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection