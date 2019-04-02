@extends('layouts.app')
@section('title', ' - Search Notes')
@section('content')
<div id="search_note">
    <div class="content_head with_border">
        <a class="icon" href="/notes">
            <img src="/img/top_note.png" alt="note">
        </a>
        <div class="text">
            <a href="/notes">Notes</a>
        </div>
        <a class="link" href="/notes/search">
            <img src="/img/note_search.png" alt="">
        </a>
        <a class="link" href="/notes/create">
            <img src="/img/note_create.png" alt="">
        </a>
    </div>
    <form method="GET" action="/notes/search/result" onsubmit="disableButton()">
        <div class="border_card">
            <div class="title">
                <div class="table_view">
                    <div class="text"><p>Search Notes</p></div>
                </div>
            </div>
            <div class="content">
                <div class="form_view">
                    @if ($errors->has('validator'))
                    <div class="help-box">
                        <strong style="font-size: 15px;">検索条件を指定してください</strong>
                    </div>
                    @endif   
                    <div class="property"><p>Keywords</p></div>
                    <div class="value">
                        <input type="text" name="keywords" class="input_text" value="{{ old('keywords') }}" placeholder="Enter keyword">
                        <div class="help-box">
                            <p>*入力したキーワードや国名が含まれるノートを検索します。複数可</p>
                        </div>
                        @if ($errors->has('keywords'))
                        <div class="help-box">
                            <strong>{{ $errors->first('keywords') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Category</p></div>
                    <div class="value">
                        @foreach ($categories as $category)
                        <div class="radio_wrapper">
                            <label for="{{ 'category'.$category->id }}"><input id="{{ 'category'.$category->id }}" class="radio_button" type="radio" name="category_id" value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'checked' : '' }}>{{ $category->name }}</label>
                        </div>
                        @endforeach
                        <div class="help-box">
                            <p>*選択されない場合、全てのカテゴリが検索対象になります。</p>
                        </div>
                        @if ($errors->has('category_id'))
                        <div class="help-box">
                            <strong>{{ $errors->first('category_id') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Tags</p></div>
                    <div class="value">
                        @foreach ($tags as $tag)
                        <div class="checkbox_wrapper">
                            <label for="{{ 'tag'.$tag->id }}"><input class="checkbox_simple" id="{{ 'tag'.$tag->id }}" type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" {{ old('tag_ids') !== null && in_array($tag->id, old('tag_ids')) ? 'checked' : '' }}>{{ $tag->name }}</label>
                        </div>
                        @endforeach
                        @if ($errors->has('tag_ids'))
                        <div class="help-box">
                            <strong>{{ $errors->first('tag_ids') }}</strong>
                        </div>
                        @endif
                        <div class="help-box">
                            <p>*選択されない場合、タグに関わらず全てのノートが検索対象になります。</p>
                        </div>                                
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Author</p></div>
                    <div class="value">
                        <input type="text" name="author" class="input_text" value="{{ old('author') }}" placeholder="Enter author">
                        <div class="help-box">
                            <p>*名字のみ、名前のみでも検索できます。</p>
                        </div>
                        @if ($errors->has('author'))
                        <div class="help-box">
                            <strong>{{ $errors->first('author') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Country</p></div>
                    <div class="value">
                        <input type="text" name="country" class="input_text" value="{{ old('country') }}" placeholder="Enter country name">
                        @if ($errors->has('country'))
                        <div class="help-box">
                            <strong>{{ $errors->first('country') }}</strong>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Date</p></div>
                    <div class="value">
                        <div class="year_month">
                            <p class="from_to">From:</p>
                            <select name="from_year" class="input_select year">
                                <option value="">Year</option>
                                @for($i = 2015; $i <= Carbon\Carbon::now()->year; $i++)
                                <option value="{{ $i }}" {{ old('from_year') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                @endfor
                            </select>
                            <select name="from_month" class="input_select month">
                                <option value="">Month</option>
                                @for($i = 1; $i <= 12 ;$i++)
                                <option value="{{ $i }}" {{ old('from_month') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="year_month">
                            <p class="from_to">To:</p>
                            <select name="to_year" class="input_select year">
                                <option value="">Year</option>
                                @for($i = 2015; $i <= Carbon\Carbon::now()->year; $i++)
                                <option value="{{ $i }}" {{ old('to_year') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                @endfor
                            </select>
                            <select name="to_month" class="input_select month">
                                <option value="">Month</option>
                                @for($i = 1; $i <= 12 ;$i++)
                                <option value="{{ $i }}" {{ old('to_month') == $i ? 'selected' : ''}}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        @if ($errors->has('from_year'))
                        <div class="help-box">
                            <strong>{{ $errors->first('from_year') }}</strong>
                        </div>
                        @endif
                        @if ($errors->has('from_month'))
                        <div class="help-box">
                            <strong>{{ $errors->first('from_month') }}</strong>
                        </div>
                        @endif
                        @if ($errors->has('to_year'))
                        <div class="help-box">
                            <strong>{{ $errors->first('to_year') }}</strong>
                        </div>
                        @endif
                        @if ($errors->has('to_month'))
                        <div class="help-box">
                            <strong>{{ $errors->first('to_month') }}</strong>
                        </div>
                        @endif                                                                                                
                    </div>
                </div>     
                <div class="form_view">
                    <div class="property"><p>Best Note</p></div>
                    <div class="value">
                        <div class="cp_ipcheck">
                            <label for="isBest"><input id ="isBest" class="checkbox_simple" type="checkbox" name="isBest" value="true" {{ old('isBest') == 1 ? 'checked' : '' }}>Best Noteのみ検索する</label>
                        </div>
                    @if ($errors->has('isBest'))
                    <div class="help-box">
                        <strong>{{ $errors->first('isBest') }}</strong>
                    </div>
                    @endif                        
                    </div>
                </div>
                <input type="hidden" value="" name="validator">
                <div class="form_view">
                    <div class="button_wrapper">
                        <button type="submit" class="bluebtn" id="disable_button">
                            <p class="button_text">Search</p>
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
@endsection