<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!-- Favicons -->
  <link rel="icon" href="/img/cap-icon.png">
  <title>
    CAP Dashboard
  </title>
  <!--   Fonts and icons   -->
  <link rel="stylesheet" type="text/css" href="{{ mix('/css/common.css') }}" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <!--   Core JS Files   -->
  <script src="{{ mix('/js/app.js') }}"></script>
</head>

<body>
  <div class="wrapper">
    @include('layouts.dashboard.sidebar')
    <div class="main-panel">
      @include('layouts.dashboard.nav')
      @yield('content')
    </div>
  </div>
</body>
</html>
