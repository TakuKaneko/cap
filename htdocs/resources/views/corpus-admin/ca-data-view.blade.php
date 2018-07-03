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
          <div class="col-5">
            <button type="button" class="btn btn-light">
              <span class="text-muted" data-feather="upload" style="width:20px;height:20px;"></span>
              <span>CSVアップロード</span>
            </button>
            <button type="button" class="btn btn-light">
              <span class="text-muted" data-feather="download" style="width:20px;height:20px;"></span>
              <span>CSVダウンロード</span>
            </button>
            <button type="button" class="btn btn-link">
              <span>サンプル</span>  
            </button>
          </div>
        </div>

        <section id="addCreativeContents" class="m-3 mt-4 mb-2">
          <div class="row">
            <div class="col-8">
              <div id="crAddBox">
                <div id="crAddBoxText">
                  <a href="#" class="callModal" data-toggle="modal" data-target="#corpusAddTextModal">
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
        </section>

        <section class="viewCreativeContents mt-3" style="width:100%;">
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="training" role="tabpanel" aria-labelledby="training-tab" style="width:100%;">
              <div class="row" style="width:100%;height:30px;margin:0;">
                <div class="h6 col-3 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">クラス</div>
                <div class="h6 col-9 border" style="margin-bottom:0;padding:5px;background-color:#E9ECEF;">関連テキスト</div>
              </div>
              <div class="row" style="width:100%;height:450px;margin:0;">
                <div class="col-3 border" style="height:470px;padding:5px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="nav flex-column nav-pills-brand" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active h6" id="v-pills-tab1" data-toggle="pill" href="#v-pills-1" role="tab" aria-controls="v-pills-1" aria-selected="true">
                      <span>景表法NG</span>
                      <span class="badge badge-pill badge-light ml-1">500</span>
                    </a>
                    <a class="nav-link h6" id="v-pills-tab2" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">
                      <span>薬機法NG</span>
                      <span class="badge badge-pill badge-light ml-1">450</span>
                    </a>
                    <a class="nav-link h6" id="v-pills-tab3" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">
                      <span>その他NG</span>
                      <span class="badge badge-pill badge-light ml-1">300</span>
                    </a>
                    <a class="nav-link h6" id="v-pills-tab4" data-toggle="pill" href="#v-pills-4" role="tab" aria-controls="v-pills-4" aria-selected="false">
                      <span>景表法OK</span>
                      <span class="badge badge-pill badge-light ml-1">500</span>
                    </a>
                    <a class="nav-link h6" id="v-pills-tab5" data-toggle="pill" href="#v-pills-5" role="tab" aria-controls="v-pills-5" aria-selected="false">
                      <span>薬機法OK</span>
                      <span class="badge badge-pill badge-light ml-1">50</span>
                    </a>
                    <a class="nav-link h6" id="v-pills-tab6" data-toggle="pill" href="#v-pills-6" role="tab" aria-controls="v-pills-6" aria-selected="false">
                      <span>その他OK</span>
                      <span class="badge badge-pill badge-light ml-1">100</span>
                    </a>
                  </div>
                </div>
                <div class="col-9 border" style="padding:5px;height:470px;overflow-y:scroll;background-color:#F8F9FA;">
                  <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active list-group" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-tab1" style="">
                      <ul class="corpusTextList">
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">1日たった5分で？帰国子女並みにペラペラなる方法</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">1日5分で英語レベル0子供がペラペラになった方法</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">NHKの人気番組で特集されたビタミンCの美容法</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">1日たった5分で？帰国子女並みの英語が話せる！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">毛穴救世主?!1月でごつごつ岩肌がもっちりプリン</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">何日に何が起こるか分かる？これ当たりすぎてヤバイ</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">リボ払いの残高が全然減らない！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">絶対あなたの金運はあがる！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">ホンマでっか？簡単な借金減額が話題になり業界騒然</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">ホンマでっか！？借金、この方法で完済しました！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">成功率92％！超お手軽ダイエットの秘密は毎日◯◯◯するだけ！？</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">毎日５分！ニキビ・くすみ・毛穴の汚れがスッキリ綺麗になる美容法</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">ほぼ10割の人が痩せた方法がアラフォーに大ウケ</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">93％が実感した食べるコラーゲンがすご！え、10歳も若く見える？</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">アラフォーでもどんどん脚が痩せる！痩せすぎて大炎上注意して！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">寝るときに履くだけでセルライト除去！？効果が凄すぎて大炎上</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">殺菌率100%＆お肌に優しいワキガ対策1位は？</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">お肌が200%うるおう、効率のいい保湿テクとは</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">1日5分で英語レベル0子供がペラペラになった方法</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">1日5分、スマホだけ！英語がスラスラ話せる！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">パウダリー史上最高　本気のカバー効果！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">顔のシミ、レーザーでないと取れないは嘘！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">保湿命だと思ってた！美容業界で一番注目の美容液</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">ここだけ！たった５問で化粧品を最安でゲット♪</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">残りわずか！１分アンケートでアスタリフトをゲット</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">【数量限定】今だけ980円で気になる口臭が爽やかに！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">プロテイン20杯分の破壊力！初月限定500円！</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">3秒に1個売れてるミネラルファンデ</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">お肌が300%潤うテクニック</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">強制的に理想的な形になるとウワサで注文殺到</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">約1ヵ月で透き通る肌になる方法</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">履くだけで美脚になる</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">これは恐るべき信頼度</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">怖いくらい当たるらしい占い</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">全く痛くない</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">女性必見！肌に優しい完全殺菌</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">完璧なカラダを目指す</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">絶対に安心</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">永久に保証</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">必ず効果がでることをお約束</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">万全のサポートを</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">最先端の商品をいち早くお届け</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">1ヶ月で簡単に効果が出る秘訣</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">飲むだけで即効</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">劇的に改善する</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">効きすぎて怖くなる</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">芸能人が愛用している</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">こっそり紹介された</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">世界初日本発の商品</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">含有が世界一日本一のもの</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">世界で一番売れている</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">1位を獲得した商品</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">最大の効果</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">最高の効果</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">最安で提供</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">最速で手に入れよう</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">最小の形状</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">最低料金を約束します</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">30秒に1回売れまくっているファンデ</a></li>
                        <li><a href="#" class="list-group-item list-group-item-action" data-toggle="modal" data-target="#corpusEditTextModal">10秒に1個売れているコスメ</a></li>
                      </ul>
                    </div>
                    <div class="tab-pane fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-tab2">2 text</div>
                    <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-tab3">3 text</div>
                    <div class="tab-pane fade" id="v-pills-4" role="tabpanel" aria-labelledby="v-pills-tab4">4 text</div>
                    <div class="tab-pane fade" id="v-pills-5" role="tabpanel" aria-labelledby="v-pills-tab5">5 text</div>
                    <div class="tab-pane fade" id="v-pills-6" role="tabpanel" aria-labelledby="v-pills-tab6">6 text</div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="test" role="tabpanel" aria-labelledby="test-tab">
              （同様に検証用の学習データを表示）
            </div>
          </div>

          <!-- テキスト追加Modal -->
          <div class="modal fade" id="corpusAddTextModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">クラス/テキストの追加</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>追加するテキストを入力してください。</p>
                  <textarea name="classifyName" cols="60" rows="3" placeholder="テキスト入力"></textarea>
                  <p>
                    <label for="classifySelect">関連させるクラスを選択してください。：</label>
                    <select id="classifySelect" name="classify">
                      <option value="1" selected>景表法NG</option>
                      <option value="2">薬機法NG</option>
                      <option value="3">その他NG</option>
                      <option value="4">景表法OK</option>
                      <option value="5">薬機法OK</option>
                      <option value="3">その他OK</option>
                      <option value="3">＋クラスを追加</option>
                    </select>
                  </p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary">保存</button>
                </div>
              </div>
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

        </section>
      </main>
@endsection