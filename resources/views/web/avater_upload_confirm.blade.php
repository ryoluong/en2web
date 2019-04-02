@extends('layouts.form')
@section('title', ' - Preview Image')
@section('content')
        <div id="avater_upload">
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="cell text"><p>Preview</p></div>
                        <div class="cell button"><p></p></div>
                    </div>
                </div>
                <div class="content">
                    <form method="POST" action="/mypage/upload_avater" enctype="multipart/form-data">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                        <div class="form_view jcenter">
                            @if(app()->isLocal())
                            <div class="image_wrapper" style="background-image:url({{ asset("/storage{$path}") }}); height: 250px; width: 250px; border-radius:20%;">
                            @else
                            <div class="image_wrapper" style="background-image:url({{ asset("{$path}") }}); height: 250px; width: 250px; border-radius:20%;">
                            @endif
                            <input type="hidden" class="input_text" name="path" value="{{ $path }}">
                            </div>
                            <div class="help-box">
                                <p>自動で画像がトリミングされます。調整したい場合、トリミングしてから再度アップロードしてください。</p>
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
@endsection
