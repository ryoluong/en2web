@extends('layouts.app')
@section('content')
<div id="registration_page">
    <form method="POST" action="{{ route('register.confirm') }}">
        {{ csrf_field() }}
        <div class="border_card">
            <div class="title">
                <div class="table_view">
                    <div class="text">
                        <p>Pre-Register</p>
                    </div>
                    <div class="link">
                    </div>
                </div>
            </div>
            <div class="content">
                <div class="form_view">
                    <div class="property">
                        <p>E-Mail Address</p>
                    </div>
                    <div class="value">
                        <input id="email" type="email" class="input_text" name="email" value="{{ old('email') }}" autofocus>
                        @if ($errors->has('email'))
                        <div class="help-box">
                            <strong>{{ $errors->first('email') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>Password</p>
                    </div>
                    <div class="value">
                        <input type="password" class="input_text" name="password" value="" required>
                        @if ($errors->has('password'))
                        <div class="help-box">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>Confirm Password</p>
                    </div>
                    <div class="value">
                        <input type="password" class="input_text" name="password_confirmation" required>
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>Registration Code</p>
                    </div>
                    <div class="value">
                        <input type="text" class="input_text" name="code" value="{{ old('code') }}" required>
                        @if ($errors->has('code'))
                        <div class="help-box">
                            <strong>{{ $errors->first('code') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="button_wrapper">
                        <button type="submit" class="bluebtn">
                            Next
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
