@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span>
  <a href="/acount">管理アカウント一覧</a>
  <span style="margin: 0 5px;"> ＞ </span>
  管理アカウント編集
@endsection

@section('content')
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title">管理アカウント編集</h4>
                  <p class="card-category">登録されている管理アカウント情報を編集してください。</p>
                </div>
                <div class="card-body">
                  <form action="/acount/confirm/1" method="post">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">氏名（姓）</label>
                          <input type="text" class="form-control" value="管理">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">氏名（名）</label>
                          <input type="text" class="form-control" value="太郎">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">氏名（セイ）</label>
                          <input type="text" class="form-control" value="カンリ">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">氏名（メイ）</label>
                          <input type="text" class="form-control" value="タロウ">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">メールアドレス</label>
                          <input type="email" class="form-control" value="admin@test.com">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">パスワード</label>
                          <input type="password" class="form-control"  value="11111111">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-10">
                        <div class="form-group">
                          <label>補足</label>
                          <div class="form-group">
                            <label class="bmd-label-floating">その他の補足事項があれば記入してください。（ex.利用用途、役職など）</label>
                            <textarea class="form-control" rows="1"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-danger pull-right">確認</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection