@extends('layouts.app')
@section('title', ' - Edit an Event')
@section('content')
        <div id="create_event">
            <form method="POST" action="/calendar/{{ $eventId }}" onsubmit="disableButton()">
            {{ csrf_field() }} 
                <div class="border_card">
                    <div class="title">
                        <div class="table_view">
                            <div class="text"><p>Edit an Event</p></div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="form_view">
                            <div class="property"><p>Title</p></div>
                            <div class="value">
                                <input type="text" name="title" class="input_text" value="{{ old('title') !== null ? old('title') : $title }}" placeholder="Enter title" required>
                                @if ($errors->has('title'))
                            <div class="help-box">
                                    <strong>{{ $errors->first('title') }}</strong>
                            </div>
                            @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>All day</p></div>
                            <div class="value">
                                <div class="cp_ipcheck">
                                    <input name="isAllDay" type="checkbox" class="checkbox_simple" value="1" onclick="disableInputs()" {{ is_null($start) ? 'checked' : '' }}>
                                </div>     
                                @if ($errors->has('isAllDay'))
                                <div class="help-box">
                                        <strong>{{ $errors->first('isAllDay') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div> 
                        <div class="form_view">
                            <div class="property"><p>Date</p></div>
                            <div class="value">
                                <input type="date" name="date" class="input_text" value="{{ old('date') !== null ? old('date') : $date }}" required>
                                @if ($errors->has('date'))
                                <div class="help-box">
                                        <strong>{{ $errors->first('date') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Time</p></div>
                            <div class="value">
                                    <input type="time" name="time_from" class="input_text input_time" value="{{ old('time_from') !== null ? old('time_from') : $start }}" {{ is_null($start) ? 'disabled' : ''}}>
                                    <p class="fromto">~</p>
                                    <input type="time" name="time_to" class="input_text input_time" value="{{ old('time_to') !== null ? old('time_to') : $end }}" {{ is_null($end) ? 'disabled' : ''}}>
                                    @if ($errors->has('time_to') || $errors->has('time_from'))
                                    <div class="help-box">
                                        <strong>{{ $errors->first('time_from') }}</strong>
                                        <strong>{{ $errors->first('time_to') }}</strong>
                                    </div>
                                    @endif
                                </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Location</p></div>
                            <div class="value">
                                <input type="text" name="location" class="input_text" value="{{ old('location') !== null ? old('location') : $location }}" placeholder="Enter location">
                                <div class="help-box">
                                    <p>*場所は任意です</p>
                                </div>
                                @if ($errors->has('location'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p>Auto-Remind</p>
                            </div>
                            <div class="value">
                                <div class="checkbox_wrapper">
                                    <label for="oneMonthBefore"><input id="oneMonthBefore" class="checkbox_simple" type="checkbox" name="oneMonthBefore" value="1" {{ $eventDb->one_month_before == 1 ? 'checked' : ''}}>１ヶ月前</label>
                                </div>
                                <div class="checkbox_wrapper">
                                    <label for="twoWeeksBefore"><input id="twoWeeksBefore" class="checkbox_simple" type="checkbox" name="twoWeeksBefore" value="1" {{ $eventDb->two_weeks_before == 1 ? 'checked' : ''}}>２週間前</label>
                                </div>
                                <div class="checkbox_wrapper">
                                    <label for="oneWeekBefore"><input id="oneWeekBefore" class="checkbox_simple" type="checkbox" name="oneWeekBefore" value="1" {{ $eventDb->one_week_before == 1 ? 'checked' : ''}}>１週間前</label>
                                </div>
                                <div class="checkbox_wrapper">
                                    <label for="theDayBefore"><input id="theDayBefore" class="checkbox_simple" type="checkbox" name="theDayBefore" value="1" {{ $eventDb->the_day_before == 1 ? 'checked' : ''}}>前日夜</label>
                                </div>
                                <div class="checkbox_wrapper">
                                    <label for="theDay"><input id="theDay" class="checkbox_simple" type="checkbox" name="theDay" value="1" {{ $eventDb->the_day == 1 ? 'checked' : ''}}>当日朝</label>
                                </div>
                            </div>
                        </div>                    
                        <div class="form_view">
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn" id="disable_button">
                                    <p class="button_text">Update</p>
                                    <div class="loader">Loading</div>
                                </button>
                                <button type="button" onclick="history.back()" class="graybtn">
                                    Back
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form> 
            <form method="POST" action="/calendar/{{ $eventId }}">
            {{ csrf_field() }}
            {{ method_field('DELETE')}}
                <div class="deletebtn">
                    <button type="submit" class="redbtn" onclick="this.disabled = true;submit();">Delete</button>
                </div>
            </form>
        </div>
@endsection