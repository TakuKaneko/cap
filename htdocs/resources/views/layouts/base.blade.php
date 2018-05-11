<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <!-- Favicons -->
  <link rel="icon" href="{{ asset('img/cap-icon.png') }}">
  <title>
    CAP Dashboard
  </title>
  <!--   Fonts and icons   -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
  <link rel="stylesheet" href="{{  asset('css/material-dashboard.css') }}">
  <!-- Documentation extras -->
</head>

<body>
  <div class="wrapper">
    @include('layouts.sidebar')

    <div class="main-panel">
      @include('layouts.nav')

      @yield('content')

      @include('layouts.footer')
      
    </div>
  </div>
</body>
<!--   Core JS Files   -->
<script src="{{ mix('js/app.js') }}"></script>
</html>
