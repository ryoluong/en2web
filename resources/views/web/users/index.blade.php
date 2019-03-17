<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="app">
            <users-index :users="{{ $users }}" :max="{{ $max }}"></users-index>
        </div>
        @include('layouts.web.footer')
        <script src=" {{ mix('js/app.js') }} "></script>
    </body>
</html>
