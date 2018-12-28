<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="create_note">
            <form method="POST" action="/notes/create" enctype="multipart/form-data">
            {{ csrf_field() }} 
                <div class="border_card">
                    <div class="title">
                        <div class="table_view">
                            <div class="text"><p>Create a New Note</p></div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="form_view">
                            <div class="property"><p>Title</p></div>
                            <div class="value">
                                <input type="text" name="title" class="input_text" value="{{ old('title') }}" placeholder="Enter title" required>
                            </div>
                            @if ($errors->has('title'))
                            <div class="help-box">
                                    <strong>{{ $errors->first('title') }}</strong>
                            </div>
                            @endif
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Author</p></div>
                            <div class="value">
                                <input type="text" name="author" class="input_text" value="{{ old('author') }}" placeholder="Enter author" required>
                                <div class="help-box">
                                    <p>*登録されているメンバーの氏名のみ有効です。</p>
                                </div>
                                @if ($errors->has('author'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('author') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Date</p></div>
                            <div class="value">
                                <input type="text" name="date" class="input_text" value="{{ old('date') }}" placeholder="yyyy-mm-dd" required>
                                @if ($errors->has('date'))
                                <div class="help-box">
                                        <strong>{{ $errors->first('date') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Country</p></div>
                            <div class="value">
                                <input type="text" name="country" class="input_text" value="{{ old('country') }}" placeholder="Ex) アメリカ 中国（複数可）">
                                <div class="help-box">
                                    <p>*任意, 日本語の通称で記入してください。</p>
                                </div>
                                @if ($errors->has('country'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('country') }}</strong>
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
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Best Note</p></div>
                            <div class="value">
                                <div class="cp_ipcheck">
                                    <label for="isBest"><input id ="isBest" class="checkbox_simple" type="checkbox" name="isBest" value="1" {{ old('isBest') == 1 ? 'checked' : '' }}>Best Noteの場合はチェック！</label>
                                </div>
                            @if ($errors->has('isBest'))
                            <div class="help-box">
                                <strong>{{ $errors->first('isBest') }}</strong>
                            </div>
                            @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Images</p></div>
                            <div class="value">
                                <input type="file" class="input_file" name="files[][photo]" accept="image/png,image/jpeg,image/gif" multiple>
                                <div class="help-box">
                                <p>*複数可, 4MBまでのjpegもしくはpng, 自動で圧縮されます。</p>
                                </div>
                                @if ($errors->has('files'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('files') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Content</p></div>
                            <div class="value">
                                <textarea class="input_textarea" type="checkbox" name="content" required>{{ old('content')}}</textarea>
                                @if ($errors->has('content'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </div>
                                 @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn">
                                    Next
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
