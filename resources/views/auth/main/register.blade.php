@extends('layouts.form')
@section('title', ' - Register')
@section('content')
<div class="loading-wrapper" v-show="loading">
    <div class="loading"></div>
</div>
<div id="registration_page" v-show="!loading">
    <form name="register_form" class="form-horizontal" method="POST" action="{{ route('register.main.confirm') }}">
        {{ csrf_field() }}
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
                        <input-vue type="text" class="input_text" name="name" component_id="register_name" placeholder="Ex) Ryo Kobayashi" required autofocus></input-vue>
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
                        <?php use Carbon\Carbon; $year = Carbon::now()->year; ?>
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
                    <div class="property">
                        <p>留学先国・地域（任意）</p>
                    </div>
                    <div class="value">
                        <input-vue type="text" class="input_text" name="countries" component_id="register_countries" placeholder="Ex) アメリカ, 香港"></input-vue>
                        <div class="help-box">
                            <p>*日本語の通称で入力してください。複数入力する場合はスペースもしくはカンマで区切ってください。</p>
                        </div>
                        @if ($errors->has('countries'))
                        <div class="help-box">
                            <strong>{{ $errors->first('countries') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>留学先大学・機関等（任意）</p>
                    </div>
                    <div class="value">
                        <input-vue type="text" class="input_text" name="university" component_id="register_university" placeholder="Ex) シドニー工科大学"></input-vue>
                        <div class="help-box">
                            <p>*複数入力する場合は , (カンマ) で区切ってください</p>
                        </div>                                
                        @if ($errors->has('university'))
                        <div class="help-box">
                            <strong>{{ $errors->first('university') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>OB, OG</p></div>
                    <div class="value">
                        <div class="cp_ipcheck">
                            <input id="isOB" name="isOB" type="checkbox" class="checkbox_simple" value="1"><label for="isOB">OB, OGの方はチェックを入れてください。</label>
                        </div>
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>就職・進路等（任意）</p>
                    </div>
                    <div class="value">
                        <input-vue type="text" class="input_text" name="job" component_id="register_job" placeholder="業界名、職種名、専攻内容など"></input-vue>
                        <input type="hidden" name="email_token" value="{{ $email_token }}">
                        <div class="help-box">
                            <p>*【上級生, 卒業生のみ】さしつかえのない範囲で、進路をご記入ください</p>
                        </div>
                        @if ($errors->has('job'))
                        <div class="help-box">
                            <strong>{{ $errors->first('job') }}</strong>
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