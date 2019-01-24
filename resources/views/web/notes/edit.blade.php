<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
        <script>
            function disableButton() {
                document.getElementById("disable_button").disabled = true;
            }
        </script>        
    </head>
    <body>
        @include('layouts.web.header')
        <div id="edit_note">
            @if(auth()->user()->isAdmin === 1 || auth()->user()->id === $note->user_id)
            <form method="POST" action="/notes/{{ $note->id }}/edit" enctype="multipart/form-data" onsubmit="disableButton()">
            {{ csrf_field() }} 
                <div class="border_card">
                    <div class="title">
                        <div class="table_view">
                            <div class="text"><p>Edit Note</p></div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="form_view">
                            <div class="property"><p>Title</p></div>
                            <div class="value">
                                <input type="text" name="title" class="input_text" value="{{ old('title') !== null ? old('title') : $note->title }}" placeholder="Enter title" required>
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
                                <input type="text" name="date" class="input_text" value="{{ old('date') !== null ? old('date') : $note->date }}" placeholder="yyyy-mm-dd" required>
                                @if ($errors->has('date'))
                                <div class="help-box">
                                        <strong>{{ $errors->first('date') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Author</p></div>
                            <div class="value">
                                <input type="text" name="author" class="input_text" value="{{ old('author') !== null ? old('author') : $note->user->name }}" placeholder="Enter author" required>
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
                            <div class="property"><p>Country</p></div>
                            <div class="value">
                                <input type="text" name="country" class="input_text" value="{{ old('country') !== null ? old('country') : $country_name }}" placeholder="Ex) アメリカ 中国（複数可）">
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
                                    <label for="{{ 'category'.$category->id }}"><input id="{{ 'category'.$category->id }}" class="radio_button" type="radio" name="category_id" value="{{ $category->id }}" {{ old('category_id') !== null ? old('category_id') == $category->id ? 'checked' : '' : $note->category_id == $category->id ? 'checked' : '' }}>{{ $category->name }}</label>
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
                                    <label for="{{ 'tag'.$tag->id }}"><input class="checkbox_simple" id="{{ 'tag'.$tag->id }}" type="checkbox" name="tag_ids[]" value="{{ $tag->id }}" {{ old('tag_ids') !== null ? in_array($tag->id, old('tag_ids')) ? 'checked' : '' : $note_tags !== null && in_array($tag->id, $note_tags) ? 'checked' : '' }}>{{ $tag->name }}</label>
                                </div>
                                @if ($errors->has('tag_ids'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('tag_ids') }}</strong>
                                </div>
                                @endif
                            @endforeach
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Best Note</p></div>
                            <div class="value">
                                <div class="cp_ipcheck">
                                    <label for="isBest"><input id ="isBest" class="checkbox_simple" type="checkbox" name="isBest" value="1" {{ old('isBest') == 1 ? 'checked' : $note->isBest == 1 ? 'checked' : '' }}>Best Noteの場合はチェック！</label>
                                </div>
                                @if ($errors->has('isBest'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('isBest') }}</strong>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="property"><p>Add Images</p></div>
                            <div class="value">
                                <input type="file" class="input_file" name="files[][photo]" accept="image/png,image/jpeg,image/gif" multiple>
                            </div>
                            @if ($errors->has('file'))
                            <div class="help-box">
                                <strong>{{ $errors->first('file') }}</strong>
                            </div>
                            @endif
                        </div>
                        @if($note->photos->count())
                        <div class="form_view">
                            <div class="property">
                                <p>Delete Images</p>
                            </div>
                            <div class="value"><p>消したい写真にチェックを入れてください</p></div>
                        </div>
                        <div class="form_view jcenter">
                            @foreach($note->photos as $photo)
                            <div class="image_wrapper" style="background-image:url({{ $photo->path }});">
                                <div class="image_delete">
                                    <div class="cp_ipcheck">
                                        <input type="checkbox" class="checkbox_simple" name="delete_paths[]" value="{{ $photo->path }}" {{ old('delete_paths') !== null && in_array($photo->path, old('delete_paths')) ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <div class="form_view">
                            <div class="property"><p>Content</p></div>
                            <div class="value">
                                <textarea class="input_textarea" type="checkbox" name="content" required>{{ old('content') !== null ? old('content') : $note->content }}</textarea>
                                @if ($errors->has('content'))
                                <div class="help-box">
                                    <strong>{{ $errors->first('content') }}</strong>
                                </div>
                                 @endif
                            </div>
                        </div>
                        <div class="form_view">
                            <div class="button_wrapper">
                                <button type="submit" class="bluebtn" id="disable_button">
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
            <div class="deletebtn">
                <button type="button" onclick="location.href='/notes/{{ $note->id }}/delete'" class="redbtn">Delete Note</button>
            </div>
            @endif
        </div>
    </body>
</html>
