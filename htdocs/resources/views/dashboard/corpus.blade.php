@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span>
  コーパス管理
@endsection

@section('page-css')
  <link rel="stylesheet" type="text/css" href="{{ mix('/css/main/dashboard/corpus.css') }}" />
@endsection

@php
//***************************************
// 日時の差を計算
//  - 最大は3ヶ月とし、それ以上は3ヶ月以上として丸める
//  - コーパスの更新日時の表示に利用
//***************************************
use Carbon\Carbon;
function time_diff($update_time) 
{
  $now = Carbon::now();
  $update_time = new Carbon($update_time);
  $diffInMinutes = $now->diffInMinutes($update_time);

  if ($diffInMinutes < 60) {
    return $now->diffInMinutes($update_time) . "分前";
  } elseif ($diffInMinutes < 60 * 24) {
    return $now->diffInHours($update_time) . "時間前";
  } elseif ($diffInMinutes < 60 * 24 * 30) {
    return $now->diffInDays($update_time) . "日前";
  } elseif ($diffInMinutes < 60 * 24 * 30 * 3) {
    return $now->diffInMonths($update_time) . "ヶ月前";
  } else {
    return "3ヶ月以上";
  }
}
@endphp

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-default">
              <h4 class="card-title">稼動コーパス一覧</h4>
            </div>
            <div class="card-body" style="padding: 10px 25px;">
              <!-- 新規作成ボタン -->
              <div class="row">
                <button type="button" class="btn btn-danger" style="margin-left:15px;" data-toggle="modal" data-target="#NlCreateModal">新規作成</button>
              </div>
              <!-- 新規作成モーダル -->
              <div class="modal fade" id="NlCreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title h3" id="exampleModalLabel">コーパスの作成</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p>コーパスを作成し教師データを学習することで、ユーザから入力されたクリエイティブの意図を分類し、結果をAPIとして提供できます。</p>
                      <form action="/corpus/view/1" method="post" name="corpus">
                        <div class="form-group">
                          <label for="corpus_name" class="bmd-label-floating">コーパス名</label>
                          <input type="text" class="form-control" id="corpus_name">
                          <span class="bmd-help">10字程度の識別しやすい名前を記入してください。</span>
                        </div>
                        <div class="form-group">
                          <label for="corpus_description" class="bmd-label-floating">説明文</label>
                          <textarea class="form-control" id="corpus_description" rows="2"></textarea>
                          <span class="bmd-help">50字以内で記入してください。</span>
                        </div>
                        <div class="form-group">
                          <label for="corpus_classifire" class="bmd-label-floating">学習種類</label>
                          {{-- <textarea class="form-control" id="corpus_classifire" rows="3"></textarea> --}}
                          <div class="form-check form-check-radio">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="corpus_classifire" id="corpus_classifire" value="text" checked>
                              自然言語
                              <span class="circle">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                          <div class="form-check form-check-radio">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="corpus_classifire" id="corpus_classifire" value="photo">
                              画像
                              <span class="circle">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                      <input type="hidden" name="_token" value="{{csrf_token()}}">
                      <input type="submit" class="btn btn-brand" value="作成" onclick="this.form.target='_blank'">
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <!-- カード一覧 -->
              <div class="row">

                <!-- カード -->
                @forelse ($corpuses as $corpus)
                  {{-- $corpus --}}
                  <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="card detail-card" style="margin:10px 0;" onclick="window.open('/corpus/view/{{ $corpus->id }}','_blank')">
                      <div class="card-body" style="padding: 15px 15px 10px 15px;">
                        <h4 class="card-title" style="width:95%;float:left;font-weight:600;">{{ $corpus->name }}</h4>
                        <div class="nav-item dropdown" style="width:5%;float:right;">
                          <a class="nav-link" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding:0;">
                            <i class="material-icons">more_vert</i>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="corpusDropdownMenuLink">
                            <a class="dropdown-item" href="/corpus/view/{{ $corpus->id }}" target="_blank">編集</a>
                            <a class="dropdown-item" href="#">複製</a>
                            <a class="dropdown-item" href="#">無効化</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">削除</a>
                          </div>
                        </div>
                        <p class="card-text" style="clear:both;margin-bottom:10px;">{{ $corpus->description }}</p>
                        {{-- <a href="/corpus/view/1" class="btn btn-sm btn-brand" target="_blank">詳細表示</a> --}}
                      </div>
                      <div class="card-footer" style="padding-top:2px;border-top: 1px solid #eee;">
                        <div class="stats pull-right">
                          関連API:「景表法と薬機法の抵触リスクチェック」
                        </div>
                      </div>
                      <div class="card-footer" style="padding-top:2px;border-top: 1px solid #eee;">
                        <div class="stats pull-right">
                          @if ($corpus->type === 1)
                            自然言語
                          @elseif ($corpus->type === 2)
                            画像
                          @endif
                        </div>
                        <div class="stats pull-left">
                          <i class="material-icons">update</i> 最終更新日：{{ time_diff($corpus->updated_at) }}
                        </div>
                      </div>
                    </div>
                  </div>
                @empty
                  <p>データなし</p>
                @endforelse

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection