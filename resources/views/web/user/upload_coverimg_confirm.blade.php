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
                            @if(app()->isLocal())
                            <div class="image_wrapper" style="background-image:url({{ asset("/storage{$path}") }}); height: 160px; width: 100%;">
                            @else
                            <div class="image_wrapper" style="background-image:url({{ asset("{$path}") }}); height: 160px; width: 100%;">
                            @endif
                            <input type="hidden" class="input_text" name="path" value="{{ $path }}">
                            </div>
                            <div class="help-box">
                                <p>※スマホからアップロードすると、画像の向きが正しく表示されない場合があります。その場合は画像をトリミングしてから再度アップロードしてください。</p>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn" name='action' value="update">
                                    Confirm
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
