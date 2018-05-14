@extends('layouts.corpus-admin.base')

@section('content')
      {{--  コンテンツ  --}}
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">データ管理</h1>
        </div>

        <div class="row">
          <div class="col-lg-4 col-md-12 col-sm-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="training-tab" data-toggle="tab" href="#training" role="tab" aria-controls="training" aria-selected="true">学習データ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="test-tab" data-toggle="tab" href="#test" role="tab" aria-controls="test" aria-selected="false">検証データ</a>
              </li>
            </ul>
          </div>
          <div class="col-lg-4 col-md-12 col-sm-12">
            <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="フリーワード検索" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">検索</button>
            </form>
          </div>
          <div class="col-lg-4 col-md-12 col-sm-12">
            <button type="button" class="btn btn-warning">CSVアップロード</button>
            <button type="button" class="btn btn-info">CSVダウンロード</button>
            <button type="button" class="btn btn-link">CSVのサンプル</button>
          </div>
        </div>

        <section class="addCreativeContents">
          <div class="fbBox">
            <div class="dText">
              <a href="#" class="callModal">
                <img src="img/plus.png" style="width:30px;height:30px;vertical-align:middle;">
                <span style="vertical-align:middle;"> 新しいのテキスト/クラスを登録</span>
              </a>
            </div>
          </div>
        </section>

        <section class="viewCreativeContents mt-3">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="training" role="tabpanel" aria-labelledby="training-tab">
              <ul>
                <li>
                  <span>sample</span>
                  <button type="button" rel="tooltip" class="btn btn-simple" onclick="location.href='#'">
                    <i class="material-icons">edit</i>
                  </button>
                  <button type="button" rel="tooltip" class="btn btn-simple" data-toggle="modal" data-target="#exampleModal">
                    <i class="material-icons">close</i>
                  </button>
                </li>
                <li>

                </li>
              </ul>
            </div>
            <div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="test-tab">test</div>
          </div>
        </section>
      </main>
@endsection