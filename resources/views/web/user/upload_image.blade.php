@extends('layouts.form')
@section('title', ' - Upload User Photo')
@section('content')
        <div id="upload">
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text"><p>{{ $flag == 'coverimg' ? 'Upload Cover Image' : 'Upload User Photo' }}</p></div>
                        <div class="link"><p></p></div>
                    </div>
                </div>
                <div class="content">
                    <form method="POST" action="{{ $flag == 'coverimg' ? '/mypage/upload_coverimg' : '/mypage/upload_avater' }}" enctype="multipart/form-data" onsubmit="disableButton()">
                    {{ csrf_field() }}
                        <div class="form_view">
                            <div class="value">
                                <input type="file" class="input_file" name="file" accept="image/png,image/jpeg,image/gif" required>
                                <div class="help-box">
                                    <p>jpegもしくはpng, 自動で圧縮されます。</p>
                                </div>
                                @if ($errors->has('files'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('files') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                            <button type="submit" class="bluebtn" id="disable_button">
                                <div class="button_text">Next</div>
                                <div class="loader">Loading</div>
                            </button>
                            <button type="button" onclick="location.href='/mypage'" class="graybtn">
                                Back
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
