<!doctype html>
<html lang=jp>
    <head>
        @include('layouts.web.head')
        <script>
            function disableButton() {
                document.getElementById("disable_button").disabled = true;
            }
        </script>        
    </head>
    <body>
        <div id="login">
            <div class="top_logo">
                <img src="img/top_logo.png" alt="en2web-logo">
                <p>A web-platform for En2 members.</p> 
            </div>
            <form method="POST" action="{{ route('login') }}" onsubmit="disableButton()">
                {{ csrf_field() }}
                <div class="login_table">
                    <div class="tr">
                        <div class="img">
                            <img src="/img/login_mail.png" alt="mail">
                        </div>
                        <div class="input">
                            <input type="email" class="input_text" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                        </div>
                    </div>
                    <div class="tr help-block">   
                        @if ($errors->has('email'))
                        <strong>{{ $errors->first('email') }}</strong>
                        @endif
                    </div>
                    <div class="tr">
                        <div class="img">
                            <img src="/img/login_pass.png" alt="">
                        </div>
                        <div class="input">
                            <input id="password" type="password" class="input_text" name="password" placeholder="Enter password" required>
                        </div>
                    </div>
                    <div class="tr help-block">   
                        @if ($errors->has('password'))
                        <strong>{{ $errors->first('password') }}</strong>
                        @endif
                    </div>
                    <div class="tr">
                        <div class="button">
                            <button type="submit" id="disable_button">Sign in</button>
                        </div>
                        <div class="cp_ipcheck"><label><input class="checkbox" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>Remember Me</label></div>
                    </div>
                    <div class="tr passreset">
                            <a href="{{ route('password.request') }}">
                                <p>Forgot Your Password?</p>
                            </a>
                    </div>
                </div>
            </form>
            <table>
                <tr>
                    <td>
                        <div class="border"></div>
                    </td>
                    <td class="text">
                        <p>or</p>
                    </td>
                    <td>
                        <div class="border"></div>
                    </td>
                </tr>
            </table>
            <button type="button" class="register" onclick="location.href='/register'">Sign up</button>
    </body>
</html>
