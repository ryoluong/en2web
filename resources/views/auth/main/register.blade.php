@extends('layouts.form')
@section('title', ' - Register')
@section('content')
<div class="loading-wrapper" v-show="loading">
    <div class="loading"></div>
</div>
<div id="registration_page" v-show="!loading">
    <form name="register_form" class="form-horizontal" method="POST" action="{{ route('register.main.confirm') }}">
        {{ csrf_field() }}
        <input type="hidden" class="input_text" name="email_token" value="{{ $email_token }}">
        <div class="border_card">
            <div class="title">
                <div class="table_view">
                    <div class="text">
                        <p>Register</p>
                    </div>
                    <div class="link">
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="form_view">
                    <div class="property">
                        <p>氏名（必須, ローマ字）</p>
                    </div>
                    <div class="value">
                        <input-vue type="text" class="input_text" name="name" component_id="register_name"
                            placeholder="Ex) Ryo Kobayashi" required autofocus></input-vue>
                        @if ($errors->has('name'))
                        <div class="help-box">
                            <strong>{{ $errors }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>入学年度（必須）</p>
                    </div>
                    <div class="value">
                        <?php $year = Carbon\Carbon::now()->year; ?>
                        <select-enroll-year class="input_select" name="year"></select-enroll-year>
                        @if ($errors->has('year'))
                        <div class="help-box">
                            <strong>{{ $errors->first('year') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <register-department></register-department>
                <div class="form_view">
                    <div class="property"><p>編入生</p></div>
                    <div class="value">
                        <div class="cp_ipcheck">
                            <input name="isHennyu" id="isHennyu" type="checkbox" class="checkbox_simple" value="1" {{ old('isHennyu') ? ' checked' : '' }}>
                            <label for="isHennyu">編入生の場合はチェックを入れてください。</label>
                        </div>
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>入会時期（必須）</p>
                    </div>
                    <div class="value">
                        <select-generation class="input_select" name="generation"></select-generation>
                        <div class="help-box">
                            <p>*{{ $year }}年度加入は{{ $year - 2014 }}期生になります。</p>
                        </div>
                        @if ($errors->has('generation'))
                        <div class="help-box">
                            <strong>{{ $errors->first('generation') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="button_wrapper">
                        <button type="submit" class="bluebtn">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection