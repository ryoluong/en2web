<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="app" class="note_show">
            <div class="content_head">
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
            <div
                class="top_photo {{ $note->isBest == 1 ? 'best_note' : ''}}"
                style="background-image:url(@if($note->photos->count()) {{ $note->photos->first()->path }} @else {{ '/img/note_cover_photo/'.$note->category_id.'.jpg' }} @endif);"
            >
                <div class="textbox">
                    <div class="title_country_wrapper">
                        <h1 class="note_title">{{ $note->title }}</h1>
                        @if($note->countries->count())
                        <div class="note_countries">
                        @foreach($note->countries as $country)
                        <a class="note_country" href="/countries/{{ $country->id }}/notes">{{ '＠'.$country->name }}&nbsp;</a>
                        @endforeach
                        </div>
                        @endif
                    </div>
                    @if($note->isBest === 1)
                    <a class="best_icon" href="/notes/best">Best Note</a>
                    @endif
                    @if(auth()->user()->isAdmin === 1 || auth()->user()->id === $note->user_id)
                    <a class="edit" href="/notes/{{ $note->id }}/edit"><img src="/img/note_edit.png" alt=""></a>
                    @endif
                    <a class="note_category" href="/categories/{{ $note->category->id }}/notes">{{ $note->category->name }}</a>
                    <fav-button class="fav-button" :note_id="{{ $note->id }}" :is_fav="{{ auth()->user()->favNotes()->where('note_id', $note->id)->count() }}" :num_of_fav="{{ $note->favUsers()->count() }}"></fav-button>
                </div>
            </div>
            <div class="author_and_date">
                <a class="note_author" href="/users/{{ $note->user->id }}/notes">
                    <img src="{{$note->user->avater_path !== null ? $note->user->avater_path : '/img/categories/user.png' }}" alt="icon">
                    <p>{{ $note->user->name }}</p>
                </a>
                <p class="note_date">{{ $note->date }}</p>
            </div>
            <h6>@foreach($note->tags as $tag)<a class="tag" href="/tags/{{ $tag->id }}/notes">{{ '#'.$tag->name }}</a>@endforeach</h6>
            @if($note->photos->count())
            <ul class="photos_wrapper">
                @foreach($note->photos as $photo)
                <li class="photo">
                    <img src="{{ $photo->path }}" alt="">
                </li>
                @endforeach
            </ul>
            @endif
            <p class="content">
            {!! $note->content !!}
            </p>
            @if(!auth()->user()->favNotes()->where('note_id', $note->id)->count())
            <div class="fav-button-wrapper"><p class="text">Like this note!</p><fav-button class="fav-button" :note_id="{{ $note->id }}" :is_fav="{{ auth()->user()->favNotes()->where('note_id', $note->id)->count() }}" :num_of_fav="{{ $note->favUsers()->count() }}"></fav-button></div>
            @endif
        </div>
        @include('layouts.web.footer')
    </body>
</html>