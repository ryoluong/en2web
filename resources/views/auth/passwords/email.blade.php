<!DOCTYPE html>
<html lang="jp">
<head>
    @include('layouts.web.head')
</head>
<body>
    @include('layouts.web.header')
    <div id="passreset_page">
        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text"><p>Reset Password</p></div>
                        <div class="link"></div>
                    </div>
                </div>
                <div class="content">
                    <div class="form_view">
                        <div class="property">
                            <p>E-Mail Address</p>
                        </div>
                        <div class="value">
                            <input type="email" class="input_text" name="email" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="help-block">
                            @if ($errors->has('email'))
                            <strong>{{ $errors->first('email') }}</strong>
                            @endif
                        </div>
                    </div>
                    <div class="form_view">
                        <div class="button_wrapper">
                            <button type="submit" class="bluebtn passreset">
                                    Send Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
