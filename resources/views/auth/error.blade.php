<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="error_page">
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text">
                            <p>Error</p>
                        </div>
                        <div class="link"></div>
                    </div>
                </div>
                <div class="content">
                    <div class="text_view">
                            <p class="card_text">{{ $message }}</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
