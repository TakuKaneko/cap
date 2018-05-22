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
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <link rel="stylesheet" href="{{  asset('css/material-dashboard.css') }}">
  <style>
    .sidebar[data-color="azure"] li.active > a {
      background-color: #00A1EA;
      box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(0, 163, 212, 0.4);
      -webkit-box-shadow: 0 4px 20px 0px rgba(0, 0, 0, 0.14), 0 7px 10px -5px rgba(0, 163, 212, 0.4);
    }
    .btn.btn-brand {
      color: #fff;
      background-color: #00A1EA;
      border-color: #00A1EA;
      -webkit-box-shadow: 0 2px 2px 0 rgba(0, 163, 212, 0.14), 0 3px 1px -2px rgba(0, 163, 212, 0.2), 0 1px 5px 0 rgba(0, 163, 212, 0.12);
              box-shadow: 0 2px 2px 0 rgba(0, 163, 212, 0.14), 0 3px 1px -2px rgba(0, 163, 212, 0.2), 0 1px 5px 0 rgba(0, 163, 212, 0.12);
    }
    .btn.btn-brand:hover {
      color: #fff;
      background-color: #43A1D4;
      border-color: #43A1D4;
    }
    .btn.btn-brand:focus,
    .btn.btn-brand.focus,
    .btn.btn-brand:hover {
      color: #fff;
      background-color: #43A1D4;
      border-color: #43A1D4;
    }
    .btn.btn-brand:active,
    .btn.btn-brand.active,
    .open > .btn.btn-brand.dropdown-toggle,
    .show > .btn.btn-brand.dropdown-toggle {
      color: #fff;
      background-color: #43A1D4;
      border-color: #43A1D4;
      -webkit-box-shadow: 0 2px 2px 0 rgba(0, 163, 212, 0.14), 0 3px 1px -2px rgba(0, 163, 212, 0.2), 0 1px 5px 0 rgba(0, 163, 212, 0.12);
              box-shadow: 0 2px 2px 0 rgba(0, 163, 212, 0.14), 0 3px 1px -2px rgba(0, 163, 212, 0.2), 0 1px 5px 0 rgba(0, 163, 212, 0.12);
    }
  </style>
  <!-- Documentation extras -->

  <!--   Core JS Files   -->
  <script src="{{ mix('js/app.js') }}"></script>
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
