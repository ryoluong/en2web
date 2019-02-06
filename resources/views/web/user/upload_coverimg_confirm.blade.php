<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="avater_upload">
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="cell text"><p>Preview</p></div>
                        <div class="cell button"><p></p></div>
                    </div>
                </div>
                <div class="content">
                    <form method="POST" action="/mypage/upload_coverimg" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                        <div class="form_view jcenter">
                            <div class="image_wrapper cover_image" style="background-image:url({{ $path }});">
                            <input type="hidden" class="input_text" name="path" value="{{ $path }}">
                            </div>
                            <div class="help-box">
                                <p>自動で中央がトリミングされます。調整したい場合は、画像をトリミングしてから再度アップロードしてください。</p>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn" id="disable_button" onclick="disableButton();submit()">
                                    <div class="button_text">Confirm</div>
                                    <div class="loader">Loading</div>
                                </button>
                                <button type="submit" class="graybtn" name='action' value="back">
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
