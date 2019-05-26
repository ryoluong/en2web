@extends('layouts.form')
@section('title', ' - Attendance')
@section('script')
<script>
    function confirmCancel() {
        if (window.confirm('出席管理をキャンセルすると入力されたデータも削除されます。\nよろしいですか？')) {
            document.cancelForm.submit();
        }
    }
    function disableDateInput() {
        document.getElementById('deadline').disabled = !document.getElementById('deadline').disabled;
    }
</script>
@endsection
@section('content')
<div id="attendance-manager">
    <div class="border_card">
        <div class="title">
            <div class="table_view">
                <div class="text">
                    @if(is_null($mtg))
                    <p>出席管理を開始する</p>
                    @else
                    <p>出席管理中：{{ $mtg->name }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="content">
            @if(is_null($mtg))
            <form method="POST" action="/meeting/add" onsubmit="disableButton()">
                {{ csrf_field() }}
                <div class="form_view">
                    <div class="property">
                        <p>タイトル</p>
                    </div>
                    <div class="value">
                        <input name="name" type="text" class="input_text" placeholder="Ex) {{ Carbon\Carbon::now()->month }}月全体MTG" value="{{ old('name') }}" required>
                        @if ($errors->has('name'))
                        <div class="help-box">
                            <strong>{{ $errors->first('name') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>開催日</p>
                    </div>
                    <div class="value">
                        <input name="date" type="date" class="input_text" value="{{ old('time') ? old('time') : Carbon\Carbon::today()->toDateString() }}" required>
                        @if($errors->has('date'))
                        <div class="help-box">
                            <strong>{{ $errors->first('date') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property">
                        <p>開始時間</p>
                    </div>
                    <div class="value">
                        <input name="time" type="time" class="input_text" value="{{ old('time') ? old('time'): '' }}" required>
                        @if($errors->has('time'))
                        <div class="help-box">
                            <strong>{{ $errors->first('time') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>LINE通知</p></div>
                    <div class="value">
                        <div class="cp_ipcheck">
                            <label for="line_notice"><input onchange="disableDateInput();" id="line_notice" class="checkbox_simple" type="checkbox" name="line_notice" value="1" checked>グループに通知を送る (推奨)</label>
                        </div>
                        <div class="help-box">
                            <p>*出席管理の開始時および回答期限の日にLINE通知がいきます。</p>
                        </div>
                        @if ($errors->has('line_notice'))
                        <div class="help-box">
                            <strong>{{ $errors->first('line_notice') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>                 
                <div class="form_view">
                    <div class="property">
                        <p>回答期限</p>
                    </div>
                    <div class="value">
                        <input name="deadline" id="deadline" type="date" class="input_text" value="{{ Carbon\Carbon::today()->toDateString() }}">
                        <div class="help-box">
                            <p>*通知を送る場合、入力が必要です。</p>
                        </div>
                    </div>
                </div>
                <div class="form_view">
                    <div class="button_wrapper">
                        <button type="submit" class="bluebtn" id="disable_button">
                            <p class="button_text">Add</p>
                            <div class="loader">Loading</div>
                        </button>
                    </div>
                </div>
            </form>
            @else
            <form method="POST" action="/meeting/{{ $mtg->id }}/complete" onsubmit="disableButton()">
                @csrf
                <div class="form_view">
                    <button id="disable_button" type="submit" class="complete-btn redbtn">
                        <p class="button_text">出席管理を完了</p>
                        <div class="loader">Loading</div>
                    </button>
                </div>
            </form>
            @endif
        </div>
    </div>
    @if($mtg)
    <div class="cancel-wrapper">
        <button class="cancel-btn graybtn" onclick="confirmCancel()">出席管理をキャンセル</button>
    </div>
    <form name="cancelForm" method="POST" action="/meeting/{{ $mtg->id }}/cancel">
        @csrf
        <button type="submit" style="display:none;"></button>
    </form>
    @endif
</div>
@endsection