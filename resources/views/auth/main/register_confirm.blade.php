@extends('layouts.form')
@section('title', ' - Confirm')
@section('content')
        <div id="registration_conf_page">
            <form class="form-horizontal" method="POST" action="{{ route('register.main.registered') }}" onsubmit="disableButton()">
                {{ csrf_field() }}
                <input type="hidden" class="input_text" name="email_token" value="{{ $email_token }}">
                <div class="border_card">
                    <div class="title">
                        <div class="table_view">
                            <div class="text"><p>Register Confirmation</p></div>
                            <div class="link">
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="form_view">
                            <div class="property"><p class="prof_head">氏名：</p></div>
                            <div class="value"><p>{{ $user->name }}</p></div>
                            <input type="hidden" class="input_text" name="name" value="{{ $user->name }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p class="prof_head">入学年度：</p>
                            </div>
                            <div class="value">
                                <p>{{ $user->year }}</p>
                            </div>
                            <input type="hidden" class="input_text" name="year" value="{{ $user->year}}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">学部：</p></div>
                            <div class="value"><p>{{ $user->department }}</p></div>
                            <input type="hidden" class="input_text" name="department" value="{{ $user->department }}" required>
                            <input type="hidden" name="department_id" value="{{ $user->department_id }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">学科：</p></div>
                            <div class="value"><p>{{ $user->major }}</p></div>
                            <input type="hidden" class="input_text" name="major" value="{{ $user->major }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">編入生：</p></div>
                            <div class="value"><p>{{ $user->isHennyu ? 'YES' : 'NO' }}</p></div>
                            <input type="hidden" class="input_text" name="isHennyu" value="{{ $user->isHennyu }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">入会時期：</p></div>
                            <div class="value"><p>{{ $user->generation."期生" }}</p></div>
                            <input type="hidden" class="input_text" name="generation" value="{{ $user->generation }}" required>
                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn" id="disable_button">
                                    <p class="button_text">Register</p>
                                    <div class="loader">Loading</div>
                                </button>
                                <button type="button" onclick="history.back()" class="graybtn">
                                    Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
@endsection