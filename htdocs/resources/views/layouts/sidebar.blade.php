
<div class="sidebar" data-color="azure" data-background-color="white">
  <div class="logo">
    <a href="{{ url('/') }}" class="simple-text logo-normal">
      <img src="{{ asset('img/cap-icon.png') }}" alt="cap_logo" width="50px" height="45px">
      <img src="{{ asset('img/cap-char-logo.png') }}" alt="cap_char" width="70px" height="45px">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      @if (Request::is('/'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="{{ url('/') }}">
          <i class="material-icons">dashboard</i>
          <p>ダッシュボード</p>
        </a>
      </li>
      {{--  @if (Request::is('acount') or Request::is('acount/edit/1'))  --}}
      @if (Request::is('acount', 'acount/edit/1', 'acount/confirm/1'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="{{ url('/acount') }}">
          <i class="material-icons">person</i>
          <p>管理アカウント</p>
        </a>
      </li>
      @if (Request::is('corpus'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="{{ url('/corpus') }}">
          <i class="material-icons">person</i>
          <p>AIコーパス管理</p>
        </a>
      </li>
      @if (Request::is('training'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="{{ url('/training') }}">
          <i class="material-icons">school</i>
          <p>AIトレーニング</p>
        </a>
      </li>
      @if (Request::is('settings'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="{{ url('/settings') }}">
          <i class="material-icons">settings</i>
          <p>各種設定</p>
        </a>
      </li>
      @if (Request::is('download'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="{{ url('/download') }}">
          <i class="material-icons">cloud_download</i>
          <p>ダウンロード</p>
        </a>
      </li>
    </ul>
  </div>
</div>
 