<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="showNotes">
                <div class="no_border_card">
                    <div class="title">
                        <div class="table_view">
                            <a class="icon" href="/notes">
                                <img src="/img/top_note.png" alt="">
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
                    <div class="content">
                        <p class="flag">
                            @if($flag == 'index')
                            @elseif($flag == 'isBest')
                            <a class="bestnote icon" href="/bestnotes">{{ 'Best Notes' }}</a>
                            @elseif($flag == 'category')
                            <a class="category icon" href="/categories/{{ $category->id }}/notes">{{ $category->name }}</a>
                            @elseif($flag == 'tag')
                            <a class="tag icon" href="/tags/{{ $tag->id }}/notes">{{ $tag->name }}</a>
                            @elseif($flag == 'author')
                            <a class="author icon" href="/users/{{ $notes->first()->user->id }}/notes">{{$notes->first()->user->name }}</a><a class="details_link" href="/users/{{ $notes->first()->user->id }}">See Profile</a>
                            @elseif($flag == 'country')
                            <a class="country icon" href="/countries/{{ $country->id }}/notes">{{ $country->name }}</a><a class="details_link" href="/countries/{{ $country->id }}">See Country</a>
                            @else
                            @endif
                        </p>
                        <!-- <div class="sp">{{ $notes->links() }}</div> -->
                        @include('layouts.web.notes')
                        <div>{{ $notes->links() }}</div>
                    </div>
                </div>
        </div>
    </body>
</html>
