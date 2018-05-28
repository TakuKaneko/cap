<div class="sidebar" data-color="azure" data-background-color="white">
  <div class="logo">
    <a href="/" class="simple-text logo-normal">
      <img src="img/cap-icon.png" alt="cap_logo" width="50px" height="45px">
      <img src="img/cap-char-logo.png" alt="cap_char" width="70px" height="45px">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      @if (Request::is('/'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="/">
          <i class="material-icons">dashboard</i>
          <p>ダッシュボード</p>
        </a>
      </li>
      @if (Request::is('corpus'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="/corpus">
          <i class="material-icons">school</i>
          <p>コーパス管理</p>
        </a>
      </li>
      @if (Request::is('api-info'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="/api-info">
          <i class="material-icons">play_for_work</i>
          <p>API管理</p>
        </a>
      </li>

      @if (Request::is('settings'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="/settings">
          <i class="material-icons">settings</i>
          <p>サービス管理</p>
        </a>
      </li>

      @if (Request::is('help'))
        <li class="nav-item active">
      @else
        <li class="nav-item">
      @endif
        <a class="nav-link" href="/help">
          <i class="material-icons">help_outline</i>
          <p>ヘルプ</p>
        </a>
      </li>
    </ul>
  </div>
</div>
 