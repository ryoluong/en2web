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
                            <p>You've Pre-Registered!</p>
                        </div>
                        <div class="link"></div>
                    </div>
                </div>
                <div class="content">
                    <div class="text_view">
                            <p class="card_text">仮登録いただきありがとうございます。</p>
                            <p class="card_text">本人確認の為、登録いただいたメールアドレスに本登録の案内メールが届きます。</p>
                            <p class="card_text">そちらに記載されているURLにアクセスし、本登録を完了してください。</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
