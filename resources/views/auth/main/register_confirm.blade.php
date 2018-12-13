<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="registration_conf_page">
            <form class="form-horizontal" method="POST" action="{{ route('register.main.registered') }}">
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
                            <div class="property"><p class="prof_head">学部：</p></div>
                            <div class="value"><p>{{ $user->department }}</p></div>
                            <input type="hidden" class="input_text" name="department" value="{{ $user->department }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">学科：</p></div>
                            <div class="value"><p>{{ $user->major }}</p></div>
                            <input type="hidden" class="input_text" name="major" value="{{ $user->major }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">入会時期：</p></div>
                            <div class="value"><p>{{ $user->generation."期生" }}</p></div>
                            <input type="hidden" class="input_text" name="generation" value="{{ $user->generation }}" required>
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">留学先国：</p></div>
                            <div class="value"><p>{{ $countries }}</p></div>
                            <input type="hidden" class="input_text" name="countries" value="{{ $countries }}" >
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">留学先大学・機関：</p></div>
                            <div class="value"><p>{{ $user->university }}</p></div>
                            <input type="hidden" class="input_text" name="university" value="{{ $user->university }}" >
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">OB・OG：</p></div>
                            <div class="value"><p>{{ $user->isOB == 1 ? "Yes" : "No" }}</p></div>
                            <input type="hidden" class="input_text" name="isOB" value="{{ $user->isOB }}" >
                        </div>
                        <div class="form_view">
                            <div class="property"><p class="prof_head">進路等：</p></div>
                            <div class="value"><p>{{ $user->job }}</p></div>
                            <input type="hidden" class="input_text" name="job" value="{{ $user->job }}" >
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