<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div class="note_show">
            <div class="no_border_card">
                <div class="title">
                    <div class="table_view">
                        <a class="icon" href="/notes">
                            <img src="/img/top_note.png" alt="note">
                        </a>
                        <div class="text">
                            <a href="/notes">
                            {{ 'Notes' }}
                            </a>
                        </div>
                        <div class="link">
                            <a href="/notes">
                                <img src="/img/note_search.png" alt="">
                            </a>
                        </div>
                        <div class="link">
                            <a href="/notes/create">
                                <img src="/img/note_create.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="top_photo" style="background-image:url(
                @if($note->photos->count())
                @if(app()->isLocal())
                {{ '/storage'.$note->photos->first()->path }}
                @else
                {{ $note->photos->first()->path }}
                @endif
                @else
                {{ '/img/note/'.$note->category_id.'.jpg' }}
                @endif
            );">
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
                    <a class="note_author" href="/users/{{ $note->user->id }}/notes">{{ $note->user->name }}</a>
                    <h5>{{ $note->date }}</h5>
                    @if($note->isBest === 1)
                    <img class="best_icon" src="/img/best_note.png" alt="">
                    @endif
                    @if(auth()->user()->isAdmin === 1)
                    <a class="edit" href="/notes/{{ $note->id }}/edit"><img src="/img/note_edit.png" alt=""></a>
                    @endif
                    <a class="note_category" href="/categories/{{ $note->category->id }}/notes">{{ $note->category->name }}</a>
                </div>
            </div>
            <h6>@foreach($note->tags as $tag)<a class="tag" href="/tags/{{ $tag->id }}/notes">{{ '#'.$tag->name }}</a>@endforeach</h6>
            @if($note->photos->count())
            <ul class="photos_wrapper">
                @foreach($note->photos as $photo)
                <li class="photo">
                    <img src="{{app()->isLocal() ? '/storage'.$photo->path : $photo->path }}" alt="">
                </li>
                @endforeach
            </ul>
            @endif
            <p class="content"><?php echo nl2br(htmlspecialchars($note->content, ENT_QUOTES, 'UTF-8')); ?></p>
            
        </div>
    </body>
</html>