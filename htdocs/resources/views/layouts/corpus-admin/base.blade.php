<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="/img/cap-icon.png">
  <title>CAP -薬機法&景表法分類-</title>

  <!-- Core CSS -->
  <link href="/css/bootstrap.css" rel="stylesheet">
  <style>
    body, html {
      font-family: "SF Pro JP","SF Pro Display","SF Pro Icons","Hiragino Kaku Gothic Pro","ヒラギノ角ゴ Pro W3","メイリオ","Meiryo","ＭＳ Ｐゴシック","Helvetica Neue","Helvetica","Arial",sans-serif;
    }
    .feather {
      width: 24px;
      height: 24px;
    }
    ::-webkit-scrollbar{
      width: 10px;
    }
    ::-webkit-scrollbar-track{
      background: #fff;
      border-left: solid 1px #ececec;
    }
    ::-webkit-scrollbar-thumb{
      background: #ccc;
      border-radius: 10px;
      box-shadow: inset 0 0 0 2px #fff;
    }
    .nav-brand {
      box-shadow: inset -1px 0 0 rgba(0, 0, 0, .12);
    }
  </style>

  <!-- Core JavaScript -->
  <script src="/js/corpus-admin-core.js"></script>

  <!-- Icons -->
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
</head>

<body>
  <header>
    <nav class="navbar navbar-dark fixed-top flex-md-nowrap p-0 shadow" style="background-color:#00A1EA;">
      <div>
        <a class="navbar-brand text-center" href="/corpus/view/1" style="padding:10px 20px 10px 10px;">
          <img src="/img/cap-icon.png" alt="cap_logo" width="25px" height="20px">
          CAP コーパス管理画面
        </a>
      </div>
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#" style="color:white;font-weight:bold;font-size:1rem;"><span> - </span>薬機法&景表法分類の文言チェック<span> - コーパス</span></a>
        </li>
      </ul>
      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#" onClick="window.close();">閉じる</a>
        </li>
      </ul>
    </nav>
  </header>

  <div class="container-fluid">
    <div class="row">
      {{--  サイドナビ  --}}
      <nav class="col-md-2 d-none d-md-block bg-light sidebar" style="font-size:1rem;">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              @if (Request::is('corpus/view/1'))
              <a class="nav-link active" href="/corpus/view/1">
              @else
              <a class="nav-link" href="/corpus/view/1">
              @endif
                <span data-feather="file-text"></span>
                基本情報
              </a>
            </li>
            <li class="nav-item">
              @if (Request::is('corpus/data/view/1'))
              <a class="nav-link active" href="/corpus/data/view/1">
              @else
              <a class="nav-link" href="/corpus/data/view/1">
              @endif
                <span data-feather="database"></span>
                データ管理
              </a>
            </li>
            {{-- <li class="nav-item">
              @if (Request::is('corpus/training/setting'))
              <a class="nav-link active" href="/corpus/training/setting">
              @else
              <a class="nav-link" href="/corpus/training/setting">
              @endif
                <span data-feather="settings"></span>
                学習設定
              </a>
            </li> --}}
            <li class="nav-item">
              @if (Request::is('corpus/training'))
              <a class="nav-link active" href="/corpus/training">
              @else
              <a class="nav-link" href="/corpus/training">
              @endif
                <span data-feather="edit"></span>
                学習管理
              </a>
            </li>
            <li class="nav-item">
              @if (Request::is('corpus/deploy/1'))
              <a class="nav-link active" href="/corpus/deploy/1">
              @else
              <a class="nav-link" href="/corpus/deploy/1">
              @endif
                <span data-feather="refresh-ccw"></span>
                本番切替
              </a>
            </li>
            {{--  <li class="nav-item">
              @if (Request::is('corpus/connect/1'))
              <a class="nav-link active" href="/corpus/connect/1">
              @else
              <a class="nav-link" href="/corpus/connect/1">
              @endif
                <span data-feather="zap"></span>
                API接続情報
              </a>
            </li>  --}}
            <li class="nav-item">
              @if (Request::is('corpus/stop/1'))
              <a class="nav-link active" href="/corpus/stop/1">
              @else
              <a class="nav-link" href="/corpus/stop/1">
              @endif
                <span data-feather="zap-off"></span>
                停止
              </a>
            </li>
          </ul>
        </div>
      </nav>

      {{--  コンテンツ  --}}
      @yield('content')
    </div>
  </div>

  <script>
      feather.replace();
  </script>
</body>
</html>
