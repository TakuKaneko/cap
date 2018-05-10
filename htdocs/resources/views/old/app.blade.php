{{-- //////////////////////////////////////////////
　SPA基本画面
　　- この画面をすべての画面で初回アクセス時に読み込む
　　- どのURLに対してもLaravelはこのファイルだけを返す
　　- 画面のレイアウトや部品はVue側で管理する 
//////////////////////////////////////////////////// --}}
<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{--  Favicon  --}}
        <link rel="icon" type="image/png" href="{{ asset('image/cap-icon.png') }}">

        {{--  Title  --}}
        <title>CAP</title>

        {{--  Fonts  --}}
        {{--  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">  --}}

        {{--  Vue.js  --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>  --}}
         @if (env('APP_DEBUG'))
            <script src="{{ asset('js/vue.js') }}"></script>
        @else
            <script src="{{ asset('js/vue.min.js') }}"></script>
        @endif 

        <script type="text/javascript">
            window.Laravel = {
                csrfToken: "{{ csrf_token() }}"
            };
        </script>

        {{--  Styles  --}}
        <link rel="stylesheet" href="{{ mix('css/app.css') }}"></script>

    </head>
    <body>
        <div id="app">
            <navbar></navbar>
            <div class="container">
                <router-view></router-view>
            </div>
        </div>
    </body>
    <script src="{{ mix('js/app.js') }}"></script>
</html>
