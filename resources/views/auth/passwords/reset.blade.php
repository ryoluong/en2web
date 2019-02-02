<!DOCTYPE html>
<html lang="jp">
<head>
    @include('layouts.web.head')
</head>
<body>
    @include('layouts.web.header')
    <div id="passreset_page">
        <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text">
                            <p>Reset Password</p>
                        </div>
                        <div class="link"></div>
                    </div>
                </div>
                <div class="content">
                    <div class="form_view">
                        <div class="property">
                            <p>E-Mail Address</p>
                        </div>
                        <div class="value">
                            <input type="email" class="input_text" name="email" value="{{ $email or old('email') }}" required autofocus>
                            <div class="help-box">
                            @if ($errors->has('email'))
                            <strong>{{ $errors->first('email') }}</strong>
                            @endif
                            </div>
                            <input type="hidden" name="token" value="{{ $token }}">
                        </div>             
                    </div>
                    <div class="form_view">
                        <div class="property">
                            <p>Password</p>
                        </div>
                        <div class="value">
                            <input type="password" class="input_text" name="password" value="">
                            <div class="help-box">
                            @if ($errors->has('password'))
                            <strong>{{ $errors->first('password') }}</strong>
                            @endif
                        </div>
                        </div>
          
                    </div>
                    <div class="form_view">
                        <div class="property">
                            <p>Confirm Password</p>
                        </div>
                        <div class="value">
                            <input type="password" class="input_text" name="password_confirmation">
                            <div class="help-box">
                        </div>
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
</body>
</html>









