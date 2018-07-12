@extends('layouts.corpus-admin.base')

@section('content')
      <style>
        .btn-outline-brand:not(:disabled):not(.disabled).active:focus, 
        .btn-outline-brand:not(:disabled):not(.disabled):active:focus, 
        .show > .btn-outline-brand.dropdown-toggle:focus {
          box-shadow: 0 0 0 0.2rem rgba(0, 163, 212,.5);
        }
        .btn-outline-brand:not(:disabled):not(.disabled).active, 
        .btn-outline-brand:not(:disabled):not(.disabled):active, 
        .show > .btn-outline-brand.dropdown-toggle {
          color: #fff;
          background-color: #00A1EA;
          border-color: #00A1EA;
        }
        .btn-outline-brand {
          color: #00A1EA;
          background-color: transparent;
          background-image: none;
          border-color: #00A1EA;
        }
        .feather {
          vertical-align: text-bottom;
        }
        .navbar-brand {
          padding-top: .75rem;
          padding-bottom: .75rem;
          font-size: 1rem;
          background-color: rgba(0, 0, 0, .25);
          box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }
        .form-control {
          padding: .75rem 1rem;
          border-width: 0;
          border-radius: 0;
          height: 35px;
        }
        .form-control-dark {
          color: #7e7575;
          background-color: rgba(132, 124, 124, .22);
          border-color: rgba(255, 255, 255, .1);
        }
        .form-control-dark:focus {
          border-color: transparent;
          box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
        }
        .border-top {
          border-top: 1px solid #e5e5e5;
        }
        .border-bottom {
          border-bottom: 1px solid #e5e5e5;
        }
        #crAddBox {
          clear: both;
          background-color: #fff;
          border-radius: 8px;
          border: solid 1px lightgray;
          padding: 10px 10px;
          position: relative;
          margin-bottom: 5px;
          width: 300px;
          height: 40px;
          font-size: 1rem;
        }
        #crAddBox:hover {
          -webkit-box-shadow: 1px 2px 5px 2px rgba(0, 0, 0, 0.2);
          box-shadow: 1px 2px 5px 2px rgba(0, 0, 0, 0.2);
          transition: 150ms;
        }
        #crAddBoxText > a {
          color: #000;
          text-decoration: none;
          outline: none;
        }
        .corpusTextList {
          list-style: none;
          padding: 0;
        }
        .nav-pills-brand .nav-link {
          border-radius: .25rem;
        }
        .nav-pills-brand .nav-link.active, .nav-pills-brand .show>.nav-link {
          color: #fff;
          background-color: #00A1EA;
       }
      </style>
      {{--  コンテンツ  --}}
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-2">
        <div class="row">
          <div class="col-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="btn btn-outline-brand nav-link active mr-1" id="training-tab" data-toggle="tab" href="#training" role="tab" aria-controls="training" aria-selected="true">学習データ</a>
              </li>
              <li class="nav-item">
                <a class="btn btn-outline-info nav-link" id="test-tab" data-toggle="tab" href="#test" role="tab" aria-controls="test" aria-selected="false">検証データ</a>
              </li>
            </ul>
          </div>
          <div class="col-4">
            {{-- <form class="form-inline my-2 my-lg-0"> --}}
            <input class="form-control form-control-dark w-100 border-bottom" type="text" placeholder="キーワード検索" aria-label="キーワード検索">
            {{-- </form> --}}
          </div>
          <!-- <div class="col-5">
            <button type="button" class="btn btn-light" data-toggle="modal" data-target="#SelectCsvModal">
              <span class="text-muted" data-feather="upload" style="width:20px;height:20px;"></span>
              <span>CSVアップロード</span>
            </button>
            <a href="/corpus/csv/download/{{ $corpus_id }}" class="btn btn-light" role="button" aria-pressed="true">
              <span class="text-muted" data-feather="download" style="width:20px;height:20px;"></span>
              <span>CSVダウンロード</span>
            </a>
            <button type="button" class="btn btn-link">
              <span><a href="/files/corpus-admin/training_data_sample.csv">サンプル</a></span>
            </button>
          </div> -->
        </div>

        <div class="row mt-3">
          <div class="col-12">
            <p>2016/10/20 10:53時点の学習データで稼働中<br><a href="/corpus/training">学習管理ページに移動</a></p>
          </div>
        </div>

        <!-- <section id="addCreativeContents" class="m-3 mt-4 mb-2">
          <div class="row">
            <div class="col-8">
              <div id="crAddBox">
                <div id="crAddBoxText">
                  <a href="#" class="callModal" data-toggle="modal" data-target="#addTrainingDataModal">
                    <span class="text-muted" data-feather="plus-circle" style="width:20px;height:20px;"></span>
                    <span style="vertical-align:middle;"> 新しいクラス/テキストを登録</span>
                  </a>
                </div>
              </div>
            </div>
            <div class="col-4 text-right">
              <span>2016/10/20 10:53時点の学習データで稼働中</span>
              <button type="button" class="btn btn-link ml-1">学習管理ページに移動</button>
            </div>
          </div>
        </section> -->


        @if(Session::has('success_msg'))
        <div class="alert alert-primary" role="alert">
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

        <section class="viewCreativeContents mt-3" style="width:100%;">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="training" role="tabpanel" aria-labelledby="training-tab" style="width:100%;"> 

              <div class="row">
                <div class="col-auto mr-auto">
                  <button type="button" class="btn btn-outline-brand" data-toggle="modal" data-target="#addTrainingDataModal">
                    <span data-feather="plus" style="width:20px;height:20px;"></span>
                    <span>新しいクラス/テキストを登録</span>
                  </button>
                </div>
                <div class="col-auto">
                  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#SelectTrainingCsvModal">
                    <span class="text-muted" data-feather="upload" style="width:20px;height:20px;"></span>
                    <span>CSVアップロード</span>
                  </button>
                  <a href="/corpus/csv/download/{{ $corpus_id }}" class="btn btn-light" role="button" aria-pressed="true">
                    <span class="text-muted" data-feather="download" style="width:20px;height:20px;"></span>
                    <span>CSVダウンロード</span>
                  </a>
                  <button type="button" class="btn btn-link">
                    <span><a href="/files/corpus-admin/training_data_sample.csv">サンプル</a></span>
                  </button>
                </div>
              </div>

              @if(count($training_classes) === 0)
              <div class="alert alert-secondary mt-2" role="alert">
                登録されているテストデータはありません。
              </div>

              @else
              <div class="row mt-2" style="width:100%;height:30px;margin:0;">
                <div class="h6 col-3 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">クラス</div>
                <div class="h6 col-9 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">関連テキスト</div>
              </div>
              <div class="row" style="width:100%;height:450px;margin:0;">
                <div class="col-3 border" style="height:470px;padding:5px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="nav flex-column nav-pills-brand" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  @foreach($training_classes as $index => $val)
                    @if($index === 0)
                      <a class="nav-link active h6" id="v-pills-tab{{ $index }}" data-toggle="pill" href="#v-pills-{{ $index }}" role="tab" aria-controls="v-pills-{{ $index }}" aria-selected="true">
                    @else
                    <a class="nav-link h6" id="v-pills-tab{{ $index }}" data-toggle="pill" href="#v-pills-{{ $index }}" role="tab" aria-controls="v-pills-{{ $index }}" aria-selected="true">
                    @endif
                      <span>{{ $val->name }}</span>
                      <span class="badge badge-pill badge-light ml-1">{{ $val->data_count }}</span>
                    </a>
                  @endforeach
                  </div>
                </div>
                <div class="col-9 border" style="padding:5px;height:470px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="tab-content" id="v-pills-tabContent">
                  @foreach($training_classes as $index => $val)
                    @if($index === 0)
                    <div class="tab-pane fade show active list-group" id="v-pills-{{ $index }}" role="tabpanel" aria-labelledby="v-pills-tab{{ $index }}" style="">
                    @else
                    <div class="tab-pane fade show list-group" id="v-pills-{{ $index }}" role="tabpanel" aria-labelledby="v-pills-tab{{ $index }}" style="">
                    @endif
                      <ul class="corpusTextList">
                    @for($i = 0; $i < count($training_creatives[$val->id]); $i++)
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">{{ $training_creatives[$val->id][$i]->content }}</a></li>
                    @endfor                        
                      </ul>
                    </div>
                  @endforeach
                    <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-tab2">2 text</div>
                    <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-tab3">3 text</div>
                    <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-tab4">4 text</div>
                    <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-tab5">5 text</div>
                    <div class="tab-pane fade" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-tab6">6 text</div>
                  </div>
                </div>
              </div>
              @endif
            </div>
            <!-- /.tab-page  -->

            <div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="test-tab">
              <div class="row">
                <div class="col-auto mr-auto">
                  <button type="button" class="btn btn-outline-info">
                    <span data-feather="plus" style="width:20px;height:20px;"></span>
                    <span>新しいクラス/テキストを登録</span>
                  </button>
                </div>
                <div class="col-auto">
                  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#SelectTextCsvModal">
                    <span class="text-muted" data-feather="upload" style="width:20px;height:20px;"></span>
                    <span>CSVアップロード</span>
                  </button>
                </div>
              </div>

              @if(count($test_classes) === 0)
              <div class="alert alert-secondary mt-2" role="alert">
                登録されているテストデータはありません。
              </div>

              @else
              <div class="row mt-2" style="width:100%;height:30px;margin:0;">
                <div class="h6 col-3 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">クラス</div>
                <div class="h6 col-9 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">関連テキスト</div>
              </div>
              <div class="row" style="width:100%;height:450px;margin:0;">
                <div class="col-3 border" style="height:470px;padding:5px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="nav flex-column nav-pills-brand" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  @foreach($test_classes as $index => $val)
                    @if($index === 0)
                      <a class="nav-link active h6" id="v-pills-tab{{ $index }}_2" data-toggle="pill" href="#v-pills-{{ $index }}_2" role="tab" aria-controls="v-pills-{{ $index }}_2" aria-selected="true">
                    @else
                    <a class="nav-link h6" id="v-pills-tab{{ $index }}_2" data-toggle="pill" href="#v-pills-{{ $index }}_2" role="tab" aria-controls="v-pills-{{ $index }}_2" aria-selected="true">
                    @endif
                      <span>{{ $val->name }}</span>
                      <span class="badge badge-pill badge-light ml-1">{{ $val->data_count }}</span>
                    </a>
                  @endforeach
                  </div>
                </div>
                <div class="col-9 border" style="padding:5px;height:470px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="tab-content" id="v-pills-tabContent">
                  @foreach($test_classes as $index => $val)
                    @if($index === 0)
                    <div class="tab-pane fade show active list-group" id="v-pills-{{ $index }}_2" role="tabpanel" aria-labelledby="v-pills-tab{{ $index }}_2" style="">
                    @else
                    <div class="tab-pane fade show list-group" id="v-pills-{{ $index }}_2" role="tabpanel" aria-labelledby="v-pills-tab{{ $index }}_2" style="">
                    @endif
                      <ul class="corpusTextList">
                    @for($i = 0; $i < count($test_creatives[$val->id]); $i++)
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">{{ $test_creatives[$val->id][$i]->content }}</a></li>
                    @endfor                        
                      </ul>
                    </div>
                  @endforeach
                  </div>
                </div>
              </div>
              @endif
            </div>
            <!-- /.tab-page  -->
          </div>


          <!-- 学習データ追加Modal -->
          <div class="modal fade" id="addTrainingDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <form action="">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">クラス/テキストの追加</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <!-- /.modal-header -->
                  <div class="modal-body">
                    <p>追加するテキストを入力してください。</p>
                    <textarea name="classifyName" rows="3" placeholder="テキスト入力" style="width: 100%;"></textarea>
                    <p>
                      <label for="classifySelect">関連させるクラスを選択してください。：</label>
                      <select id="classifySelect" name="classify">
                      @foreach($training_classes as $index => $val)
                        @if($index === 0)
                        <option value="{{ $val->id }}" selected>{{ $val->name }}</option>
                        @else
                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                        @endif

                      @endforeach
                        <!-- <option value="add">＋クラスを追加</option> -->
                      </select>
                    </p>
                  </div>
                  <!-- /.modal-body -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary">保存</button>
                  </div>
                  <!-- /.modal-footer --> 
                </form>
                <!-- /from -->
              </div>
              <!-- /.modal-content -->
            </div>
          </div>

          <!-- テキスト編集Modal -->
          <div class="modal fade" id="corpusEditTextModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">テキスト編集</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>テキスト/クラスを編集したら保存ボタンをクリックしてください。</p>
                  <textarea name="classifyName" cols="60" rows="3">成功率92％！超お手軽ダイエットの秘密は毎日◯◯◯するだけ！？</textarea>
                  <p>
                    <label for="classifySelect">関連させるクラスを選択してください。：</label>
                    <select id="classifySelect" name="classify">
                      <option value="1" selected>景表法NG</option>
                      <option value="2">薬機法NG</option>
                      <option value="3">その他NG</option>
                      <option value="4">景表法OK</option>
                      <option value="5">薬機法OK</option>
                      <option value="3">その他OK</option>
                    </select>
                  </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary">削除</button>
                  <button type="button" class="btn btn-primary">保存</button>
                </div>
              </div>
            </div>
          </div>

          <!-- 学習データアップロード -->
          <div class="modal fade" id="SelectTrainingCsvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <form action="/corpus/csv/upload/{{ $corpus_id }}/training" method="post" enctype="multipart/form-data" id="csvUpload">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">学習データのアップロード</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <!-- /.modal-header -->
                  <div class="modal-body">
                    <input type="file" value="ファイルを選択" name="csv_file">
                    {{ csrf_field() }}
                  </div>
                  <!-- /.modal-body -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-primary">アップロードする</button>
                  </div>
                  <!-- /.modal-footer -->
                </form>
              </div>
            </div>
          </div>
          <!-- /#SelectCsvModal -->

          <!-- テストデータアップロード -->
          <div class="modal fade" id="SelectTextCsvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <form action="/corpus/csv/upload/{{ $corpus_id }}/test" method="post" enctype="multipart/form-data" id="csvUpload">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">テストデータのアップロード</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <!-- /.modal-header -->
                  <div class="modal-body">
                    <input type="file" value="ファイルを選択" name="csv_file">
                    {{ csrf_field() }}
                  </div>
                  <!-- /.modal-body -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-primary">アップロードする</button>
                  </div>
                  <!-- /.modal-footer -->
                </form>
              </div>
            </div>
          </div>
          <!-- /#SelectCsvModal -->


        </section>
      </main>
@endsection