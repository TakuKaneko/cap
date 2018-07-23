@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span>
  コーパス管理
@endsection

@section('page-css')
  <link rel="stylesheet" type="text/css" href="{{ mix('/css/main/dashboard/corpus.css') }}" />
  <style>
    .bd-callout {
      padding: 1.25rem;
      margin-top: 1.25rem;
      margin-bottom: 1.25rem;
      border: 1px solid #eee;
      border-left-width: .25rem;
      border-radius: .25rem;
    }
    .bd-callout p {
      margin-bottom: 0;
    }
    .bd-callout-warning {
      border-left-color: #f0ad4e;
    }
  </style>
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


              <div class="row">
                <div class="col-12">
                  <div class="bd-callout bd-callout-warning">
                    <p>作成できるコーパスは8個までです。</p>
                  </div>
                </div>
              </div>

              <!-- 新規作成ボタン -->
              <div class="row mt-2">
              @if(count($corpuses) < 8) 
                <button type="button" class="btn btn-danger" style="margin-left:15px;" data-toggle="modal" data-target="#addCorpusModal">新規作成</button>
              @else
                <button type="button" class="btn btn-default" style="margin-left:15px;" disabled>新規作成</button>
              @endif
              </div>
              <!-- /.row -->

            @if(count($corpuses) > 0)
              <!-- カード一覧 -->
              <div class="row">
              @foreach($corpuses as $corpus)
                
                <!-- カード -->
                <div class="col-lg-4 col-md-4 col-sm-6">
                  <div class="card detail-card" style="margin:10px 0;" onclick="window.open('/corpus/view/{{ $corpus->id }}','_blank')" data-corpus-id="{{ $corpus->id }}" data-corpus-name="{{ $corpus->name }}" data-corpus-is-production="{{ $corpus->is_production }}">
                  @if($corpus->is_production)
                    <span class="ribbon13-2">本番</span>
                  @else
                    <span class="ribbon13-3">検証</span>
                  @endif
                    <div class="card-body" style="padding: 15px 15px 10px 15px;">
                      <h4 class="card-title" style="width:95%;float:left;font-weight:600;">{{ $corpus->name }}</h4>
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
                      <p class="card-text" style="clear:both;margin-bottom:10px;">{{ $corpus->description }}</p>
                      {{-- <a href="/corpus/view/1" class="btn btn-sm btn-brand" target="_blank">詳細表示</a> --}}
                    </div>
                  @if($corpus->related_api_text !== "") 
                    <div class="card-footer" style="padding-top:2px;border-top: 1px solid #eee;">
                      <div class="stats pull-right">
                        関連API:{{ $corpus->related_api_text }}
                      </div>
                    </div>
                  @endif
                    <div class="card-footer" style="padding-top:2px;border-top: 1px solid #eee;">
                      <div class="stats pull-right">
                        {{\App\Enums\CorpusType::getDescription($corpus->type)}}
                      </div>
                      <div class="stats pull-left">
                        <i class="material-icons">update</i> 最終更新日：{{ time_diff($corpus->updated_at ) }}
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.col -->
              @endforeach

              </div>
              <!-- /.row -->
            @else
              <div class="row">
                <p style="margin-left:15px;">登録されているコーパスはありません</p>
              </div>
            @endif
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /.content -->


  <!-- 新規作成モーダル -->
  <div class="modal fade" id="addCorpusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/corpus/create" method="post" name="corpus" id="corpus_create_form">
          <div class="modal-header">
            <h5 class="modal-title h3" id="exampleModalLabel">コーパスの作成</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- /.modal-header -->
          <div class="modal-body">
            <p>コーパスを作成し教師データを学習することで、ユーザから入力されたクリエイティブの意図を分類し、結果をAPIとして提供できます。</p>
            <div class="form-group">
              <label for="corpus_name" class="bmd-label-floating">コーパス名</label>
              <input type="text" name="name" value="{{ old('name') }}" class="form-control" id="corpus_name" required>
              <span class="bmd-help">10字程度の識別しやすい名前を記入してください。</span>
              <div class="invalid-feedback">
                テキストを入力してください
              </div>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label for="corpus_description" class="bmd-label-floating">説明文</label>
              <textarea name="description" class="form-control" id="corpus_description" rows="2" required>{{ old('description') }}</textarea>
              <span class="bmd-help">50字以内で記入してください。</span>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <label for="exampleFormControlSelect1">言語</label>
              <select name="language" class="form-control" id="exampleFormControlSelect1">
              @foreach($language_list as $language)
                <option value="{{ $language['value'] }}">{{ $language['label'] }}</option>
              @endforeach
              </select>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.modal-body -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="submit" class="btn btn-brand" value="作成">
          </div>
          <!-- /.modal-footer -->
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal -->

  <!-- 削除モーダル -->
  <div class="modal fade" id="deleteCorpusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form action="/corpus/delete" method="post" name="corpus" id="corpus_delete_form">
          <div class="modal-header">
            <h5 class="modal-title h3" id="exampleModalLabel">コーパスの削除</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- /.modal-header -->
          <div class="modal-body">
            <p class="confirm-message">コーパスを削除すると、登録されている教師データが全て削除され、関連しているAPIも応答ができなくなります。</p>
          </div>
          <!-- /.modal-body -->
          <div class="modal-footer text-center">
            <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button> -->
            <button type="button" class="btn btn-danger" id="delete-confirm-btn">確認</button>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" name="corpus_id" value="" id="h-corpus-id">
          </div>
          <!-- /.modal-footer -->
        </form>
      </div>
    </div>
  </div>
  <!-- /.modal -->
@endsection

@section('page-js')
  <script src="{{ mix('/js/main/dashboard/context-menu.js') }}"></script>
@endsection