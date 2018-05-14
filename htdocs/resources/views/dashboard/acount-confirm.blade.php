@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span>
  <a href="/acount">管理アカウント一覧</a>
  <span style="margin: 0 5px;"> ＞ </span>
  <a href="/acount/edit/1">管理アカウント編集</a>
  <span style="margin: 0 5px;"> ＞ </span>
  管理アカウント編集確認
@endsection

@section('content')
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-10">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title">管理アカウント編集確認</h4>
                  <p class="card-category">以下の情報で登録してもよろしいですか？</p>
                </div>
                <div class="card-body">
                  <form action="/acount" method="post">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">氏名（姓）</label>
                          <span class="form_text">管理</span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">氏名（名）</label>
                          <span class="form_text">太郎</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">氏名（セイ）</label>
                          <span class="form_text">カンリ</span>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label class="bmd-label-floating">氏名（メイ）</label>
                          <span class="form_text">タロウ</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">メールアドレス</label>
                          <span class="form_text">admin@test.com</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label class="bmd-label-floating">パスワード</label>
                          <span class="form_text">********</span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-10">
                        <div class="form-group">
                          <label>補足</label>
                          <div class="form-group">
                          </div>
                        </div>
                      </div>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-danger pull-right">確定</button>
                    <div class="clearfix"></div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection