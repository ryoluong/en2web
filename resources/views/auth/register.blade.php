<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
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
                            </div>
                            <div class="help-box">
                                @if ($errors->has('email'))
                                <strong>{{ $errors->first('email') }}</strong>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p>Password</p>
                            </div>
                            <div class="value">
                                <input type="password" class="input_text" name="password" value="" required>
                            </div>
                            <div class="help-box">
                                @if ($errors->has('password'))
                                <strong>{{ $errors->first('password') }}</strong>
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
                            <div class="help-box">
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p>Registration Code</p>
                            </div>
                            <div class="value">
                                <input type="text" class="input_text" name="code" value="{{ old('code') }}" required>
                            </div>

                            <div class="help-box">
                                   @if ($errors->has('code'))
                                    <strong>{{ $errors->first('code') }}</strong>
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
    </body>
</html>
