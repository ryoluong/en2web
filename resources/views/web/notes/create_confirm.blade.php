@extends('layouts.form')
@section('content')
<div id="create_note">
    <div class="border_card">
        <div class="title">
            <div class="table_view">
                <div class="cell text"><p>Create a New Note</p></div>
                <div class="cell button"><p></p></div>
            </div>
        </div>
        <div class="content">
            <form method="POST" action="/notes" enctype="multipart/form-data">
            {{ csrf_field() }}
                <div class="form_view">
                    <div class="property"><p>Title：</p></div>
                    <div class="value">
                        <p>{{ $title }}</p>
                        <input type="hidden" class="input_text" name="title" value="{{ $title }}">
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Date：</p></div>
                    <div class="value">
                        <p>{{ $date }}</p>
                        <input type="hidden" class="input_text" name="date" value="{{ $date }}">
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Author：</p></div>
                    <div class="value">
                        <p>{{ $author }}</p>
                        <input type="hidden" class="input_text" name="author" value="{{ $author }}">
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Country：</p></div>
                    <div class="value">
                        <p>{{ $country }}</p>
                        <input type="hidden" class="input_text" name="country" value="{{ $country }}">
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Category：</p></div>
                    <div class="value">
                        <p>{{ $categories->where('id', $category_id)->first()->name }}</p>
                        <input type="hidden" class="input_text" name="category_id" value="{{ $category_id }}">
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Tags：</p></div>
                    <div class="value">
                    @if(isset($tag_ids))
                    @foreach ($tag_ids as $tag_id)
                        <p>{{ $tags->where('id', $tag_id)->first()->name."　" }} </p>
                        <input type="hidden" class="input_text" name="tag_ids[]" value="{{ $tag_id }}">
                    @endforeach
                    @endif
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>Best Note：</p></div>
                    <div class="value">
                        <p>{{ isset($isBest) ? "Yes" : "No" }}</p>
                        <input type="hidden" class="input_text" name="isBest" value="{{ isset($isBest) ? 1 : 0 }}">
                    </div>
                </div>
                <div class="form_view">
                    <div class="property"><p>LINE Notification：</p></div>
                    <div class="value">
                        <p>{{ isset($line_notice) ? "Yes" : "No" }}</p>
                        <input type="hidden" class="input_text" name="line_notice" value="{{ isset($line_notice) ? 1 : 0 }}">
                    </div>
                </div>                
                <div class="form_view jcenter">
                    @foreach($paths as $path)

                    @if(app()->isLocal())
                    <div class="image_wrapper" style="background-image:url({{ asset("/storage{$path}") }});">
                    @else
                    <div class="image_wrapper" style="background-image:url({{ asset("{$path}") }});">
                    @endif
                        <input type="hidden" class="input_text" name="paths[]" value="{{ $path }}">
                    </div>
                    @endforeach
                </div>
                <div class="form_view">
                    <div class="long_text">
                        <p><?php echo nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')); ?></p>
                        <input type="hidden" class="input_text" name="content" value="{{ $content }}">
                    </div>
                </div>
                <div class="form_view">
                    <div class="button_wrapper">
                        <button type="submit" class="bluebtn" name='action' value="create">
                            Create
                        </button>
                        <button type="submit" class="graybtn" name='action' value="back">
                            Back
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection