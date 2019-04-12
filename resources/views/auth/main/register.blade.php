@extends('layouts.form')
@section('title', ' - Register')
@section('script')
<script>
    function departmentSwitch() {
        var eles = document.getElementsByClassName('switch');
        for(var ele of eles) {
            if(ele.disabled == true) {
                ele.disabled = false;
            } else {
                ele.disabled = true;
            }
        }
    }
    function putNewMajors() {
        var obj = document.getElementById('newDepartments');
        var value = obj.value;
        var target = document.getElementById('newMajors');
        resetOptions(target);
        switch(value) {
            case '経済学部':
                putOptions(target, ['経済学科']);
                break;
            case '経営学部':
                putOptions(target, ['経営学科']);
                break;
            case '教育学部':
                putOptions(target, ['教育学科']);
                break;
            case '都市科学部':
                putOptions(target, ['都市社会共生学科', '建築学科', '環境リスク共生学科', '都市基盤学科']);
                break;
            default:
                putOptions(target, ['機械・材料・海洋系学科', '化学・生命系学科', '数物・電子情報系学科']);
                break;
        }  
    }
    function putOldMajors() {
        var obj = document.getElementById('oldDepartments');
        var value = obj.value;
        var target = document.getElementById('oldMajors');
        resetOptions(target);
        switch(value) {
            case '経済学部':
                putOptions(target, ['経済システム学科', '国際経済学科']);
                break;
            case '経営学部':
                putOptions(target, ['経営学科', '会計・情報学科', '経営システム学科', '国際経営学科'])
                break;
            case '教育人間科学部':
                putOptions(target, ['学校教育課程', '人間文化課程'])
                break;
            default:
                putOptions(target, ['機械工学・材料系学科', '化学・生命系学科', '建築都市・環境系学科', '数物・電子情報系学科'])
                break;
        }
    }
    function resetOptions(target) {
        target.textContent = null;
    }
    function putOptions(target, majors) {
        for(major of majors) {
            var option = document.createElement('option');
            option.value = major;
            option.textContent = major;
            target.appendChild(option);
        }
    }
</script>
@endsection
@section('content')
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
                            @for($i = $year - 4; $i <= $year; $i++)
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
                        <p>学科編成</p>
                    </div>
                    <div class="value">
                        <div class="radio_wrapper">
                            <label for="departments_new"><input id="departments_new" class="radio_button" value="new" name="selection" type="radio" onChange="departmentSwitch();" checked>2017年度以降</label>
                        </div>  
                        <div class="radio_wrapper">
                            <label for="departments_old"><input id="departments_old" class="radio_button" value="old" name="selection" type="radio" onChange="departmentSwitch();">2016年度以前</label>
                        </div>
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>学部（必須）</p>
                    </div>
                    <div class="value">
                        <select id="newDepartments" class="input_select switch" name="department" onChange="putNewMajors();">
                            <option value="経済学部">経済学部</option>
                            <option value="経営学部">経営学部</option>
                            <option value="教育学部">教育学部</option>
                            <option value="都市科学部">都市科学部</option>
                            <option value="理工学部">理工学部</option>
                        </select>
                        <select id="oldDepartments" class="input_select switch" name="department" onChange="putOldMajors();" disabled>
                            <option value="経済学部">経済学部</option>
                            <option value="経営学部">経営学部</option>
                            <option value="教育人間科学部">教育人間科学部</option>
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
                        <select id="newMajors" class="input_select switch" name="major">
                            <option value="経済学科">経済学科</option>
                        </select>
                        <select id="oldMajors" class="input_select switch" name="major" disabled>
                            <option value="国際経済学科">国際経済学科</option>
                            <option value="経済システム学科">経済システム学科</option>
                        </select>
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>入会時期（必須）</p>
                    </div>
                    <div class="value">
                        <select class="input_select" name="generation">
                            @for($i = $year - 2018; $i <= $year - 2014; $i++)
                                <option value="{{ $i }}" {{ $year - 2014 === $i ? "selected" : "" }}>{{ $i."期生" }}</option>
                            @endfor
                        </select>
                        <div class="help-box">
                            <p>*{{ $year }}年度加入は{{ $year - 2014 }}期生になります。</p>
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
                        <p>留学先国・地域（任意）</p>
                    </div>
                    <div class="value">
                        <input type="text" class="input_text" name="countries" value="{{ old('countries') }}" placeholder="Ex) アメリカ, 香港">
                        <div class="help-box">
                            <p>*日本語の通称で入力してください, 複数入力する場合はスペースもしくはカンマで区切ってください</p>
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
                        <p>留学先大学・機関等（任意）</p>
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
                        <p>就職・進路等（任意）</p>
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
@endsection