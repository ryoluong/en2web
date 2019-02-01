<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="registration_page">
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
                                <input type="text" class="input_text" name="name" value="{{ isset($user->name) ? $user->name : old('name')}}" placeholder="Ex) Ryo Kobayashi" required autofocus>
                                @if ($errors->has('name'))
                                <div class="help-box">
                                        <strong>{{ $errors->first('name') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p>入学年度（必須）</p>
                            </div>
                            <div class="value">
                                <select name="year" id="year" class="input_select">
                                    <?php use Carbon\Carbon; $year = Carbon::now()->year; ?>
                                    @for($i = 2012; $i <= $year; $i++)
                                    <option value="{{ $i }}" {{ $i == $year ? 'selected' : ''}}>{{ $i }}</option>    
                                    @endfor
                                </select>
                                @if ($errors->has('year'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('year') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p>学部（必須）</p>
                            </div>
                            <div class="value">
                                <select class="input_select" name="department">
                                    <option value="経済学部">経済学部</option>
                                    <option value="経営学部">経営学部</option>
                                    <option value="教育学部">教育学部</option>
                                    <option value="都市科学部">都市科学部</option>
                                    <option value="理工学部">理工学部</option>
                                </select>
                                @if ($errors->has('department'))
                                <div class="help-box">
                                        <strong>{{ $errors->first('department') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p>学科（必須）</p>
                            </div>
                            <div class="value">
                                <select class="input_select" name="major">
                                    <option value="経済学科">経済学科</option>
                                    <option value="経営学科">経営学科</option>
                                    <option value="教育学科">教育学科</option>
                                    <option value="都市社会共生学科">都市社会共生学科</option>
                                    <option value="建築学科">建築学科</option>
                                    <option value="環境リスク共生学科">環境リスク共生学科</option>
                                    <option value="都市基盤学科">都市基盤学科</option>
                                    <option value="機械・材料・海洋系学科">機械・材料・海洋系学科</option>
                                    <option value="化学・生命系学科">化学・生命系学科</option>
                                    <option value="数物・電子情報系学科">数物・電子情報系学科</option>
                                </select>
                                <div class="help-box">
                                  <p>*2016年度以前入学の方はそれに準ずる学部・学科をお選びください。</p>
                                </div>
                                @if ($errors->has('major'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('major') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p>入会時期（必須）</p>
                            </div>
                            <div class="value">
                                <select class="input_select" name="generation">
                                    @for($i = 1; $i <= $max + 1; $i++)
                                        <option value="{{ $i }}" {{ $user->generation === $i ? "selected" : "" }}>{{ $i."期生" }}</option>
                                    @endfor
                                </select>
                                <div class="help-box">
                                   <p>*2018年度加入が4期生になります。</p>
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
                                <p>留学先国・地域</p>
                            </div>
                            <div class="value">
                                <input type="text" class="input_text" name="countries" value="" placeholder="Ex) アメリカ, 香港">
                                <div class="help-box">
                                    <p>*複数可, 日本語の通称で入力してください</p>
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
                                <p>留学先大学・機関等</p>
                            </div>
                            <div class="value">
                                <input type="text" class="input_text" name="university" value="{{ old('university') }}" placeholder="Ex) シドニー工科大学">
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
                                <p>就職・進路等</p>
                            </div>
                            <div class="value">
                                <input type="text" class="input_text" name="job" value="{{ old('job') }}" placeholder="業界名、職種名、専攻内容など">
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
    </body>
</html>