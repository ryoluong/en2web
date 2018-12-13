<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="mypage">
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text"><p>Edit Profile</p></div>
                        <div class="link"><p></p></div>
                    </div>
                </div>
                <div class="content">
                    <form method="POST" action="/mypage/update">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                        <div class="form_view">
                            <div class="property"><p>入学年度</p></div>
                            <div class="value">
                                <input name="year" type="text" class="input_text" value="{{ old('year') !== null ? old('year') : $user->year }}" placeholder="西暦4ケタで入力してください">
                            </div>
                            @if ($errors->has('year'))
                            <div class="help-box">
                                <strong>{{ $errors->first('year') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form_view">
                            <div class="property"><p>学部</p></div>
                            <div class="value">
                                <select class="input_select" name="department">
                                    <option value="経済学部" {{ $user->department == '経済学部' ? ' selected' : '' }}>経済学部</option>
                                    <option value="経営学部" {{ $user->department == '経営学部' ? ' selected' : '' }}>経営学部</option>
                                    <option value="教育学部" {{ $user->department == '教育学部' ? ' selected' : '' }}>教育学部</option>
                                    <option value="都市科学部" {{ $user->department == '都市科学部' ? ' selected' : '' }}>都市科学部</option>
                                    <option value="理工学部" {{ $user->department == '理工学部' ? ' selected' : '' }}>理工学部</option>
                                </select>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>学科</p></div>
                            <div class="value">
                                <select class="input_select" name="major">
                                    <option value="経済学科" {{ $user->major == '経済学科' ? ' selected' : '' }}>経済学科</option>
                                    <option value="経営学科" {{ $user->major == '経営学科' ? ' selected' : '' }}>経営学科</option>
                                    <option value="教育学科" {{ $user->major == '教育学科' ? ' selected' : '' }}>教育学科</option>
                                    <option value="都市社会共生学科" {{ $user->major == '都市社会共生学科' ? ' selected' : '' }}>都市社会共生学科</option>
                                    <option value="建築学科" {{ $user->major == '建築学科' ? ' selected' : '' }}>建築学科</option>
                                    <option value="環境リスク共生学科" {{ $user->major == '環境リスク共生学科' ? ' selected' : '' }}>環境リスク共生学科</option>
                                    <option value="都市基盤学科" {{ $user->major == '都市基盤学科' ? ' selected' : '' }}>都市基盤学科</option>
                                    <option value="機械・材料・海洋系学科" {{ $user->major == '機械・材料・海洋系学科' ? ' selected' : '' }}>機械・材料・海洋系学科</option>
                                    <option value="化学・生命系学科" {{ $user->major == '化学・生命系学科' ? ' selected' : '' }}>化学・生命系学科</option>
                                    <option value="数物・電子情報系学科" {{ $user->major == '数物・電子情報系学科' ? ' selected' : '' }}>数物・電子情報系学科</option>
                                </select>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>入会時期</p></div>
                            <div class="value">
                                <select class="input_select" name="generation">
                                    @for($i = 1; $i <= $max + 1; $i++)
                                        <option value="{{ $i }}" {{ $user->generation === $i ? "selected" : "" }}>{{ $i."期生" }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>留学先国・地域</p></div>
                            <div class="value">
                                <input name="countries" type="text" class="input_text" value="@foreach($user->countries()->get() as $country){{ $country->name.'　' }}@endforeach">
                            </div>
                            <div class="help-box">
                              <p>*複数可</p>
                            </div>
                            @if ($errors->has('countries'))
                            <div class="help-box">
                                    <strong>{{ $errors->first('countries') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form_view">
                            <div class="property"><p>留学先大学・機関</p></div>
                            <div class="value">
                                <input name="university" type="text" class="input_text" value="{{ old('university') !== null ? old('university') : $user->university }}">
                            </div>
                            @if ($errors->has('university'))
                            <div class="help-box">
                                    <strong>{{ $errors->first('university') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form_view">
                            <div class="property"><p>OB・OG</p></div>
                            <div class="value">
                                <div class="cp_ipcheck">
                                    <input name="isOB" type="checkbox" class="checkbox_simple" value="1" {{ $user->isOB == 1 ? ' checked' : '' }}>
                                </div>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>就職・進路等</p></div>
                            <div class="value">
                                <input name="job" type="text" class="input_text" value="{{ old('job') !== null ? old('job') : $user->job }}">
                            </div>
                            <div class="help-box">
                              <p>*【上級生, 卒業生のみ】さしつかえのない範囲で、進路をご記入ください</p>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Profile</p></div>
                            <div class="value">
                                <textarea name="profile" class="input_textarea" placeholder="例)３年次に、交換留学で１年間ハノイ貿易大学へ行っていました。現在はIT開発やその勉強に取り組んでいます！">{{ old('profile') !== null ? old('profile') : $user->profile }}</textarea>
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                            <button type="submit" class="bluebtn">
                                Save
                            </button>
                            <button type="button" onclick="history.back()" class="graybtn">
                                Back
                            </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
