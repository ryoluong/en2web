@extends('layouts.form')
@section('title', ' - Edit Profile')
@section('content')
        <div id="mypage">
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text"><p>Edit Profile</p></div>
                        <div class="link"><p></p></div>
                    </div>
                </div>
                <div class="content">
                    <form method="POST" action="/mypage/update" onsubmit="disableButton()">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                        <div class="form_view">
                            <div class="property">
                                <p>Instagram ID</p>
                            </div>
                            <div class="value">
                                <input name="instagram_id" type="text" class="input_text" value="{{ old('instagram_id') ? old('instagram_id') : $user->instagram_id }}">
                                @if ($errors->has('instagram_id'))
                                <div class="help-box">
                                        <strong>{{ $errors->first('instagram_id') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property">
                                <p>Twitter ID</p>
                            </div>
                            <div class="value">
                                <input name="twitter_id" type="text" class="input_text" value="{{ old('twitter_id') ? old('twitter_id') : $user->twitter_id }}">
                                <div class="help-box">
                                    <p>*「＠」は無しでご入力ください。</p>
                                </div>
                                @if ($errors->has('twitter_id'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('twitter_id') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>留学先国名または地域名</p></div>
                            <div class="value">
                                <input name="countries" type="text" class="input_text" value="@foreach($user->countries()->get() as $country){{ $country->name.' ' }}@endforeach">
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
                            <div class="property"><p>留学先大学・機関</p></div>
                            <div class="value">
                                <input name="university" type="text" class="input_text" value="{{ old('university') !== null ? old('university') : $user->university }}">
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
                            <div class="property"><p>留学中</p></div>
                            <div class="value">
                                <div class="cp_ipcheck">
                                    <input name="isOverseas" type="checkbox" class="checkbox_simple" value="1" {{ $user->isOverseas == 1 ? ' checked' : '' }}>
                                </div>
                            </div>
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
                                <div class="help-box">
                              <p>*【上級生, 卒業生のみ】さしつかえのない範囲で、進路をご記入ください</p>
                            </div>
                        </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Profile</p></div>
                            <div class="value">
                                <textarea name="profile" class="input_textarea" placeholder="">{{ old('profile') !== null ? old('profile') : $user->profile }}</textarea>
                                <div class="help-box">
                                    <p>* %%見出し%%と入力すると<span>見出し</span>になります。</p>
                                </div>
                            </div>

                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn" id="disable_button">
                                    <p class="button_text">Save</p>
                                    <div class="loader">Loading</div>
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
@endsection