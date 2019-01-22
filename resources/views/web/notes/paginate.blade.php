<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="showNotes">
            <div class="content_head with_border">
                <a class="icon" href="/notes">
                    <img src="/img/top_note.png" alt="">
                </a>
                <div class="text">
                    <a href="/notes">Notes</a>
                </div>
                <a class="link" href="/search/notes">
                    <img src="/img/note_search.png" alt="">
                </a>
                <a class="link" href="/notes/create">
                    <img src="/img/note_create.png" alt="">
                </a>
            </div>
            @if($flag == 'isBest')
            <div class="category_wrapper">
                <img class="category_icon" src="/img/categories/best.png" alt="bestnotes">
                <p class="category_name">Best Notes</p>
            </div>    
            @elseif($flag == 'category')
            <div class="category_wrapper">
                <img class="category_icon" src="/img/categories/category.png" alt="category">
                <p class="category_name">{{ $category->name }}</p>
            </div>
            @elseif($flag == 'tag')
            <div class="category_wrapper">
                <img class="category_icon" src="/img/categories/tag.png" alt="tag">
                <p class="category_name">{{ $tag->name }}</p>
            </div>
            @elseif($flag == 'author')
            <div class="category_wrapper">
                <img class="user_icon" src="{{ $user->avater_path !== null ? $user->avater_path : '/img/categories/user.png' }}" alt="user">
                <p class="category_name">{{ $user->name }}</p>
                <a class="link" href="/users/{{ $user->id }}">See profile</a>
            </div>
            @elseif($flag == 'country')
            <div class="category_wrapper">
                <img class="category_icon" src="/img/flags/{{ $country->english_name }}.png" alt="country">
                <p class="category_name">{{ $country->name }}</p>
                <a class="link" href="/countries/{{ $country->id }}">See country</a>
            </div>
            @elseif($flag == 'search')
            <div class="category_wrapper">
                <img class="category_icon" src="/img/categories/search.png" alt="country">
                <p class="category_name">検索結果</p>
            </div>
            @else
            <div class="category_wrapper">
                <img class="category_icon" src="/img/categories/allnotes.png" alt="all notes">
                <p class="category_name">全てのノート</p>
            </div>
            @endif
            <div class="numOfNotes"><p>{{ $count }}件のノート</p></div>
            @if($flag == 'search')
            <div class="sp_block">{{ $notes->appends(request()->all())->links() }}</div>
            @else
            <div class="sp_block">{{ $notes->links() }}</div>
            @endif
            <ul class="note_view">
            @foreach($notes as $note)
            @include('layouts.web.notes')
            @endforeach
            </ul>
            @if($flag == 'search')
            {{ $notes->appends(request()->all())->links() }}
            @else
            {{ $notes->links() }}
            @endif
        </div>
    </body>
</html>
