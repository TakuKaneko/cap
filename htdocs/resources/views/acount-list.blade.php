@extends('layouts.base')

@section('title')
  <a href="{{ url('/') }}">TOP</a> <span style="margin: 0 5px;"> ＞ </span> 管理アカウント一覧
@endsection

@section('content')
            <div class="content">
                <div class="container-fluid">
                    @isset($msg)
                        <script>
                            demo.showNotification('top', 'right');
                        </script>
                    @endisset
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
                                                        <button type="button" rel="tooltip" class="btn btn-simple">
                                                            <i class="material-icons">close</i>
                                                        </button>
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