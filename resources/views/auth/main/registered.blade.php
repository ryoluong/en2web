<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="registered_page">
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text">
                            <p>You've Successfully Registered!</p>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="text_view">
                        <p class="card_text">En2::Webへの本登録ありがとうございます。</p>
                        <p class="card_text">今からご利用いただけます。</p>
                        <p class="card_text" style="text-align:center"><a href="/login">トップへ戻る</a></p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
