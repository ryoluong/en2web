<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')       
    </head>
    <body>
        @include('layouts.web.header')
        <div id="create_event">
            <form method="POST" action="/calendar" onsubmit="disableButton()">
            {{ csrf_field() }} 
                <div class="border_card">
                    <div class="title">
                        <div class="table_view">
                            <div class="text"><p>Add a New Event</p></div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="form_view">
                            <div class="property"><p>Title</p></div>
                            <div class="value">
                                <input type="text" name="title" class="input_text" value="{{ old('title') }}" placeholder="Enter title" required>
                                @if ($errors->has('title'))
                            <div class="help-box">
                                    <strong>{{ $errors->first('title') }}</strong>
                            </div>
                            @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Date</p></div>
                            <div class="value">
                                <input type="date" name="date" class="input_text" value="{{ old('date') !== null ? old('date') : $today }}" required>
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
                                    <input type="time" name="time_from" class="input_text input_time" value="{{ old('time_from') }}" required>
                                    <p class="fromto">~</p>
                                    <input type="time" name="time_to" class="input_text input_time" value="{{ old('time_to') }}" required>
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
                                <input type="text" name="location" class="input_text" value="{{ old('location') }}" placeholder="Enter location">
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
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn" id="disable_button">
                                    <p class="button_text">Add</p>
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
        </div>
    </body>
</html>