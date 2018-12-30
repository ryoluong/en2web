<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="registration_conf_page">
            <form class="form-horizontal" method="POST" action="{{ route('register.existing.user') }}">
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
                            <div class="property"><p class="prof_head">Name:</p></div>
                            <div class="value">
                                <p>{{ $user->name }}</p>
                                <div class="help-box">
                                    <p>*ご自身の名前であることを必ず確認してください。</p>
                                </div>
                            </div>
                            
                        </div>
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
                                <button type="submit" class="bluebtn">
                                    Register
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