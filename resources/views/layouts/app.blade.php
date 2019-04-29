<!DOCTYPE html>
<html lang="ja">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>En2::Web @yield('title')</title>

        @include('layouts.favicons')

        <!-- Styles -->
        <link type="text/css" rel="stylesheet" href="{{ mix('css/en2webstyle.css') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
            integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

        @if(!app()->isLocal())
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-131467484-2"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'UA-131467484-2');
        </script>
        @endif

        <!-- Script -->
        <script>
            function disableButton() {
                document.getElementById("disable_button").disabled = true;
            }

            function disableInputs() {
                var eles = document.getElementsByClassName('input_time');
                for (var ele of eles) {
                    ele.disabled = !ele.disabled;
                }
            }
        </script>
        @yield('script')
    </head>

    <body>
        <div id="app">
            @include('layouts.header')
            @yield('content')
            @include('layouts.footer')
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>

</html>