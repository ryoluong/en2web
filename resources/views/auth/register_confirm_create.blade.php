@extends('layouts.form')
@section('title', ' - Confirm')
@section('content')
        <div id="registration_conf_page">
            <form class="form-horizontal" method="POST" action="{{ route('register') }}" onsubmit="disableButton()">
                {{ csrf_field() }}
                <div class="border_card">
                    <div class="title">
                        <div class="table_view">
                            <div class="text"><p>Pre-Register Confirmation</p></div>
                            <div class="link">
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="form_view">
                            <div class="property"><p class="prof_head">E-Mail Address:</p></div>
                            <div class="value"><p>{{ $email }}</p></div>
                            <input type="hidden" class="input_text" name="email" value="{{ $email }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">Password:</p></div>
                            <div class="value"><p>{{ $password_mask }}</p></div>
                            <input type="hidden" class="input_text" name="password" value="{{ $password }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">Registration Code:</p></div>
                            <div class="value"><p>{{ $code_mask }}</p></div>
                            <input type="hidden" class="input_text" name="code" value="{{ $code }}" required>
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