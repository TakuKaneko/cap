@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span>
  AIコーパス管理
@endsection

@section('content')
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title">自然言語分類コーパス</h4>
                </div>
                <div class="card-body" style="padding: 10px 25px;">
                  <p> 「自然言語分類コーパス」は、入力されたショート・テキストの言語を理解し、意図を分析するのに役立ちます。意図は"クラス"として分類され、学習データからトレーニングした後、トレーニングされていないテキストに対するクラス情報を予測して返すことができるようになります。</p>
                  <!-- 新規作成ボタン -->
                  <div class="row">
                    <button type="button" class="btn btn-danger" style="margin-left:15px;" data-toggle="modal" data-target="#NlCreateModal">新規作成</button>
                  </div>
                  <!-- 新規作成モーダル -->
                  <div class="modal fade" id="NlCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title h3" id="exampleModalLabel">自然言語分類コーパスの作成</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>自然言語分類コーパスを使用すると、入力された自然言語の意図を分類し、分類結果をクライアントに提供することができます。</p>
                          <form action="/corpus/view/1" method="post">
                            <div class="form-group">
                              <label for="nl_corpus_name" class="bmd-label-floating">コーパス名</label>
                              <input type="text" class="form-control" id="nl_corpus_name">
                              <span class="bmd-help">10字以内で識別しやすい名前を記入してください。</span>
                            </div>
                            <div class="form-group">
                              <label for="nl_corpus_description" class="bmd-label-floating">コーパス説明</label>
                              <textarea class="form-control" id="nl_corpus_description" rows="3"></textarea>
                              <span class="bmd-help">50字以内で記入してください。</span>
                            </div>
                            <div class="form-group">
                              <label class="mr-sm-2" for="nl_corpus_language">言語</label>
                              <select class="custom-select mb-2 mr-sm-2 mb-sm-0" id="nl_corpus_language">
                                <option value="japanese" selected>日本語</option>
                                <option value="english">英語</option>
                              </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                          <input type="hidden" name="_token" value="{{csrf_token()}}">
                          <input type="submit" class="btn btn-primary" value="作成" onclick="this.form.target='_blank'">
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- カード一覧 -->
                  <div class="row">
                    <!-- カード１ -->
                    <div class="col-lg-4 col-md-4 col-sm-6">
                      <div class="card" style="margin:10px 0;">
                        <div class="card-body" style="padding: 15px 15px 10px 15px;">
                          <h4 class="card-title" style="width:95%;float:left;font-weight:600;">薬機法＆景表法分類</h4>
                          <div class="nav-item dropdown" style="width:5%;float:right;">
                            <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0;">
                              <i class="material-icons">more_vert</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="corpusDropdownMenuLink">
                              <a class="dropdown-item" href="/corpus/view/1" target="_blank">編集</a>
                              <a class="dropdown-item" href="#">複製</a>
                              <a class="dropdown-item" href="#">無効化</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#">削除</a>
                            </div>
                          </div>
                          <p class="card-text" style="clear:both;margin-bottom:10px;">クリエイティブが薬機法もしくは景表法に抵触する可能性の有無を分類する。</p>
                          <a href="/corpus/view/1" class="btn btn-sm btn-primary" target="_blank">詳細表示</a>
                        </div>
                        <div class="card-footer" style="padding-top:0;">
                          <div class="stats">
                              <i class="material-icons">update</i> 最終更新日：２日前
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- カード２ -->
                    <div class="col-lg-4 col-md-4 col-sm-6">
                      <div class="card" style="margin:10px 0;">
                        <div class="card-body" style="padding: 15px 15px 10px 15px;">
                            <h4 class="card-title" style="width:95%;float:left;font-weight:600;">サンプル</h4>
                          <div class="nav-item dropdown" style="width:5%;float:right;">
                            <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0;">
                              <i class="material-icons">more_vert</i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="corpusDropdownMenuLink">
                              <a class="dropdown-item" href="#">編集</a>
                              <a class="dropdown-item" href="#">複製</a>
                              <a class="dropdown-item" href="#">無効化</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#">削除</a>
                            </div>
                          </div>
                          <p class="card-text" style="clear:both;margin-bottom:10px;">未使用のため無効化中。</p>
                          <a href="#" class="btn btn-sm btn-primary">詳細表示</a>
                        </div>
                        <div class="card-footer" style="padding-top:0;">
                          <div class="stats">
                              <i class="material-icons">update</i> 最終更新日：１５日前
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- VRエリア -->
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title">画像分類コーパス</h4>
                </div>
                <div class="card-body" style="padding: 10px 25px;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection