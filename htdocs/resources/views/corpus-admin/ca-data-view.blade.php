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
        /* .form-control {
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
        } */
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

        @if($corpus->is_production) 
        <div class="row mt-3">
          <div class="col-12">
            <div class="alert alert-info" role="alert">
              2016/10/20 10:53時点の学習データで稼働中<a href="/corpus/training" class="ml-3">学習管理ページに移動</a>
            </div>
            <!-- <div class="col-12">
              <p>2016/10/20 10:53時点の学習データで稼働中<br><a href="/corpus/training">学習管理ページに移動</a></p>
            </div> -->
          </div>
        </div>
        <!-- /.row -->
        @endif


        <div class="row mt-3">
          <div class="col-3">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="btn btn-outline-brand nav-link active mr-1" id="training-tab" data-toggle="tab" href="#training" role="tab" aria-controls="training" aria-selected="true">学習データ</a>
              </li>
              <li class="nav-item">
                <a class="btn btn-outline-info nav-link" id="test-tab" data-toggle="tab" href="#test" role="tab" aria-controls="test" aria-selected="false">テストデータ</a>
              </li>
            </ul>
          </div>
          <div class="col-4">
            {{-- <form class="form-inline my-2 my-lg-0"> --}}
            <input class="form-control form-control-dark w-100 border-bottom" type="text" placeholder="キーワード検索" aria-label="キーワード検索">
            {{-- </form> --}}
          </div>
        </div>


        @if(Session::has('success_msg'))
        <div class="alert alert-success" role="alert">
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


        @if(count($errors) > 0)
        <div class="alert alert-danger" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <ul style="margin-bottom: 0;">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
          </ul>
        </div>
        @endif


        <section class="viewCreativeContents mt-3" style="width:100%;">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="training" role="tabpanel" aria-labelledby="training-tab" style="width:100%;"> 

              <div class="row">
                <div class="col-auto mr-auto">
                <button type="button" class="btn btn-outline-brand" data-toggle="modal" data-target="#addClassTextModal" data-datatype="1" data-mtitle="クラス/テキスト追加">
                  <span data-feather="plus" style="width:20px;height:20px;"></span>
                  <span>クラス/テキスト追加</span>
                </button>
                </div>
                <div class="col-auto">
                  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#SelectTrainingCsvModal">
                    <span class="text-muted" data-feather="upload" style="width:20px;height:20px;"></span>
                    <span>CSVアップロード</span>
                  </button>
                  <a href="/corpus/csv/download/{{ $corpus->id }}" class="btn btn-light" role="button" aria-pressed="true">
                    <span class="text-muted" data-feather="download" style="width:20px;height:20px;"></span>
                    <span>CSVダウンロード</span>
                  </a>
                  <button type="button" class="btn btn-link">
                    <span><a href="/files/corpus-admin/training_data_sample.csv">サンプル</a></span>
                  </button>
                </div>
              </div>

              @if(count($corpus_classes) === 0)
              <div class="alert alert-secondary mt-2" role="alert">
                登録されているクラス/テストデータはありません。
              </div>

              @else
              <div class="row mt-2" style="width:100%;height:30px;margin:0;">
                <div class="h6 col-3 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">クラス</div>
                <div class="h6 col-9 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">関連テキスト</div>
              </div>

              <div class="row" style="width:100%;height:450px;margin:0;">
                <div class="col-3 border" style="height:470px;padding:5px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="nav flex-column nav-pills-brand" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  @foreach($corpus_classes as $index => $class)
                    @if($index === 0)
                      <a class="nav-link active h6" id="v-pills-tab{{ $index }}" data-toggle="pill" href="#v-pills-{{ $index }}" role="tab" aria-controls="v-pills-{{ $index }}" aria-selected="true">
                    @else
                    <a class="nav-link h6" id="v-pills-tab{{ $index }}" data-toggle="pill" href="#v-pills-{{ $index }}" role="tab" aria-controls="v-pills-{{ $index }}" aria-selected="true">
                    @endif
                      <span>{{ $class->name }}</span>
                      <span class="badge badge-pill badge-light ml-1">{{ $class->training_data_count }}</span>
                    </a>
                  @endforeach
                  </div>
                  <!-- /.nav -->
                </div>
                <!-- /.col-3 -->

                <div class="col-9 border" style="padding:5px;height:470px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="tab-content" id="v-pills-tabContent">
                  @foreach($corpus_classes as $index => $class)
                    @if($index === 0)
                    <div class="tab-pane fade show active list-group" id="v-pills-{{ $index }}" role="tabpanel" aria-labelledby="v-pills-tab{{ $index }}" style="">
                    @else
                    <div class="tab-pane fade show list-group" id="v-pills-{{ $index }}" role="tabpanel" aria-labelledby="v-pills-tab{{ $index }}" style="">
                    @endif

                    @if(count($training_creatives[$class->id]) === 0)
                    <div class="alert alert-secondary mt-2" role="alert">
                      登録されているテキストはありません
                    </div>
                    @else
                      <ul class="corpusTextList">
                     @for($i = 0; $i < count($training_creatives[$class->id]); $i++)
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" 
                          data-target="#editClassTextModal" data-mtitle="テキスト編集" data-classid="{{ $class->id }}" data-content="{{ $training_creatives[$class->id][$i]->content }}" 
                          data-creativeid="{{ $training_creatives[$class->id][$i]->id }}" data-datatype="1">{{ $training_creatives[$class->id][$i]->content }}</a></li>
                      @endfor
                    @endif
                      </ul>
                    </div>
                  @endforeach
                  </div>
                  <!-- /.tab-content -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              @endif
            </div>
            <!-- /.tab-pane  -->

            <div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="test-tab">
              @if(count($corpus_classes) > 0)
              <div class="row">
                <div class="col-auto mr-auto">
                  <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#addClassTextModal" data-datatype="0" data-mtitle="新しいクラス/テキストの登録">
                    <span data-feather="plus" style="width:20px;height:20px;"></span>
                    <span>クラス/テキスト追加</span>
                  </button>
                </div>
                <div class="col-auto">
                  <button type="button" class="btn btn-light" data-toggle="modal" data-target="#SelectTextCsvModal">
                    <span class="text-muted" data-feather="upload" style="width:20px;height:20px;"></span>
                    <span>CSVアップロード</span>
                  </button>
                </div>
              </div>
              <!-- /.row -->

              <div class="row mt-2" style="width:100%;height:30px;margin:0;">
                <div class="h6 col-3 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">クラス</div>
                <div class="h6 col-9 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">関連テキスト</div>
              </div>
              <div class="row" style="width:100%;height:450px;margin:0;">
                <div class="col-3 border" style="height:470px;padding:5px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="nav flex-column nav-pills-brand" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  @foreach($corpus_classes as $index => $class)
                    @if($index === 0)
                      <a class="nav-link active h6" id="v-pills-tab{{ $index }}_2" data-toggle="pill" href="#v-pills-{{ $index }}_2" role="tab" aria-controls="v-pills-{{ $index }}_2" aria-selected="true">
                    @else
                    <a class="nav-link h6" id="v-pills-tab{{ $index }}_2" data-toggle="pill" href="#v-pills-{{ $index }}_2" role="tab" aria-controls="v-pills-{{ $index }}_2" aria-selected="true">
                    @endif
                      <span>{{ $class->name }}</span>
                      <span class="badge badge-pill badge-light ml-1">{{ $class->test_data_count }}</span>
                    </a>
                  @endforeach
                  </div>
                </div>
                <div class="col-9 border" style="padding:5px;height:470px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="tab-content" id="v-pills-tabContent">
                  @foreach($corpus_classes as $index => $class)
                    @if($index === 0)
                    <div class="tab-pane fade show active list-group" id="v-pills-{{ $index }}_2" role="tabpanel" aria-labelledby="v-pills-tab{{ $index }}_2" style="">
                    @else
                    <div class="tab-pane fade show list-group" id="v-pills-{{ $index }}_2" role="tabpanel" aria-labelledby="v-pills-tab{{ $index }}_2" style="">
                    @endif

                    @if(count($test_creatives[$class->id]) === 0)                    
                      <div class="alert alert-secondary mt-2" role="alert">
                        登録されているテキストはありません
                      </div>
                    @else
                      <ul class="corpusTextList">
                        @for($i = 0; $i < count($test_creatives[$class->id]); $i++)
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" 
                          data-target="#editClassTextModal" data-mtitle="テキスト編集" data-classid="{{ $class->id }}" data-content="{{ $test_creatives[$class->id][$i]->content }}" 
                          data-creativeid="{{ $test_creatives[$class->id][$i]->id }}" data-datatype="0">{{ $test_creatives[$class->id][$i]->content }}</a></li>
                        @endfor
                      </ul>
                    @endif
                    </div>
                  @endforeach
                  </div>
                </div>
              </div>
              @else
              <div class="alert alert-secondary mt-2" role="alert">
                登録されているテストクラス/テストデータはありません。
              </div>
              <!-- /.alert -->
              @endif
            </div>
            <!-- /.tab-pane  -->
          </div>
        </section>

        <!-- 学習データ追加Modal -->
        <div class="modal fade" id="addClassTextModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="/corpus/data/create/{{ $corpus->id }}" method="post" class="needs-validation" id="add-content-form">
                {{ csrf_field() }}
                <div class="modal-header">
                  <h5 class="modal-title"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="alert alert-warning" role="alert">
                    追加するデータを入力してください
                  </div>
                  <!-- /.alert -->

                  <div class="default-form-area mt-4">
                    <div class="form-group">
                      <label for="addContent">追加するテキスト</label>
                      <textarea name="content" class="form-control" id="addContent" rows="3" required>{{ old('content') }}</textarea>
                      <small class="form-text text-muted">1024文字以内で入力してください。</small>
                      <div class="invalid-feedback">
                        テキストを入力してください
                      </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                      <label for="selectClass">クラス選択</label>
                      <select name="corpus_class_id" class="form-control form-control-sm" id="selectClass">
                      @foreach($corpus_classes as $index => $class)
                        @if($index === 0)
                        <option value="{{ $class->id }}" selected>{{ $class->name }}</option>
                        @else
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endif
                      @endforeach
                        <option value="">＋クラスを追加</option>
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.default-form-area -->

                  <div id="add-class-form-area">
                    <div class="form-group">
                      <label for="addClass">追加するクラス名</label>
                      <input type="text" name="add_class_name" class="form-control" id="addClass">
                      <div class="invalid-feedback">
                        クラス名を入力してください
                      </div>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.add-class-form-area -->
                </div>
                <!-- /.modal-body -->
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" id="add_content_btn">保存する</button>
                  <input type="hidden" name="data_type" class="add_data_type">
                </div>
                <!-- /.modal-footer -->
              </form>
              <!-- /form -->
            </div>
            <!-- /.modal-content -->
          </div>
        </div>
        <!-- /学習データ追加Modal -->


        <!-- テキスト編集Modal -->
        <div class="modal fade" id="editClassTextModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content" id="edit-content">
              <form action="/corpus/data/edit/{{ $corpus->id }}" method="post" class="needs-validation" id="edit-content-form">
                {{ csrf_field() }}
                <div class="modal-header">
                  <h5 class="modal-title"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="alert alert-warning" role="alert">
                    クラス/テキストを変更できます。
                  </div>
                  <!-- /.alert -->

                  <div class="default-form-area mt-4">
                    <div class="form-group">
                      <label for="addContent">テキスト</label>
                      <textarea name="content" class="form-control" id="addContent" rows="3" required></textarea>
                      <small class="form-text text-muted">1024文字以内で入力してください。</small>
                      <div class="invalid-feedback">
                        テキストを入力してください
                      </div>
                    </div>
                    <!-- /.form-group -->
                    <div class="form-group">
                      <label for="selectClass">クラス選択</label>
                      <select name="corpus_class_id" class="form-control form-control-sm" id="selectClass">
                      @foreach($corpus_classes as $index => $class)
                        @if($index === 0)
                        <option value="{{ $class->id }}" selected>{{ $class->name }}</option>
                        @else
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endif

                      @endforeach
                      </select>
                    </div>
                    <!-- /.form-group -->
                  </div>
                  <!-- /.default-form-area -->
                </div>
                <!-- /.modal-body -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" id="delConflBtn">削除する</button>
                  <button type="submit" class="btn btn-primary">変更する</button>
                  <input type="hidden" name="data_type" class="current_data_type">
                  <input type="hidden" name="creative_id" class="creative_id">
                </div>
                <!-- /.modal-footer -->
              </form>
              <!-- /form -->
            </div>
            <!-- /.modal-content -->

            <div class="modal-content" id="del-content" style="display:none;">
            <form action="/corpus/data/delete/{{ $corpus->id }}" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                  <h5 class="modal-title">テキスト削除</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="alert alert-danger" role="alert">
                    テキストを削除しようとしています。
                  </div>
                  <!-- /.alert -->

                  <div class="default-form-area mt-4">
                    <p>削除をやめる場合は、キャンセルボタンを押してください。</p>
                  </div>
                  <!-- /.default-form-area -->
                </div>
                <!-- /.modal-body -->
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" id="closeBtn">キャンセル</button>
                  <button type="submit" class="btn btn-danger">削除する</button>
                  <input type="hidden" name="creative_id" class="creative_id">
                  <input type="hidden" name="data_type" class="current_data_type">
                </div>
                <!-- /.modal-footer -->
              </form>
              <!-- /form -->
            </div>
            <!-- /.modal-content -->
          </div>
        </div>
        <!-- /テキスト編集モーダル -->


        <!-- 学習データアップロード -->
        <div class="modal fade" id="SelectTrainingCsvModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="/corpus/data/csv/upload/{{ $corpus->id }}/{{ \App\Enums\CorpusDataType::Training }}" method="post" enctype="multipart/form-data" id="csvUpload">
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
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form action="/corpus/data/csv/upload/{{ $corpus->id }}/{{ \App\Enums\CorpusDataType::Test }}" method="post" enctype="multipart/form-data" id="csvUpload">
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

      </main>
@endsection