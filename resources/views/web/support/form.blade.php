<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="support">
            <div class="content_head with_border">
                <div class="icon">
                    <img src="/img/top_support.png" alt="support">
                </div>
                <div class="text">
                    <p>Support</p>
                </div>
            </div>        
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text"><p>送信フォーム</p></div>
                    </div>
                </div>
                <div class="content">
                    <form method="POST" action="/support" onsubmit="disableButton()">
                    {{ csrf_field() }}
                        <div class="form_view">
                            <div class="property"><p>Message</p></div>
                            <div class="value">
                                <textarea name="message" class="input_textarea" placeholder="不具合の報告、機能の要望、開発へのメッセージなど何でもお送りください！" required></textarea>
                                <div class="help-box">
                                    <p>*匿名で送信されるため、対応が必要な場合には氏名を明記してください。</p>
                                </div>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn" id="disable_button">
                                    <p class="button_text">Send</p>
                                    <div class="loader">Loading</div>
                                </button>
                            <button type="button" onclick="history.back()" class="graybtn">
                                Back
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
