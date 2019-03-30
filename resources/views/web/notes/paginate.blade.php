<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="app">
            <div class="content_head with_border">
                <a class="icon" href="/notes">
                    <img src="/img/top_note.png" alt="">
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
            @if($flag == 'isBest')
            <div class="category_wrapper">
                <img class="category_icon" src="/img/categories/best.png" alt="bestnotes">
                <p class="category_name">Best Notes</p>
            </div>    
            @elseif($flag == 'like')
            <div class="category_wrapper">
                <img class="category_icon" src="/img/categories/like.png" alt="heart">
                <p class="category_name">Liked Notes</p>
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
            <div class="category_wrapper icon_decoration">
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
            @if($flag == 'search')
            <div class="search_conditions">
                @if(!empty(request('keywords')))
                <div class="conditions_wrapper">
                    <p class="property">Keyword</p>
                    <p class="value">{{ request('keywords') }}</p>
                </div>
                @endif
                @if(!is_null(request('category_id')))
                <div class="conditions_wrapper">
                    <p class="property">Category</p>
                    <p class="value">{{ App\Category::where('id', request('category_id'))->first()->name }}</p>
                </div>
                @endif
                @if(!is_null(request('tag_ids')))
                <div class="conditions_wrapper">
                    <p class="property">Tag</p>
                    <p class="value">
                        @foreach(request('tag_ids') as $tag_id)
                        {{ App\Tag::where('id', $tag_id)->first()->name }}
                        @endforeach
                    </p>
                </div>
                @endif
                @if(!empty(request('author')))
                <div class="conditions_wrapper">
                    <p class="property">Author</p>
                    <p class="value">{{ request('author') }}</p>
                </div>
                @endif
                @if(!empty(request('country')))
                <div class="conditions_wrapper">
                    <p class="property">Country</p>
                    <p class="value">{{ request('country') }}</p>
                </div>
                @endif
                @if(!empty(request('from_year')))
                <div class="conditions_wrapper">
                    <p class="property">Date</p>
                    <p class="value">{{ request('from_year').'年' }}{{ !empty(request('from_month')) ? request('from_month').'月' : ''}}から</p>
                </div>
                @endif         
                @if(!empty(request('to_year')))
                <div class="conditions_wrapper">
                    <p class="property">{{ empty(request('from_year')) ? 'Date' : '' }}</p>
                    <p class="value">{{ request('to_year').'年' }}{{ !empty(request('to_month')) ? request('to_month').'月' : ''}}まで</p>
                </div>
                @endif     
                @if(!empty(request('isBest')))
                <div class="conditions_wrapper">
                    <p class="property">Best Note</p>
                    <p class="value">Best Noteのみ</p>
                </div>
                @endif                                                 
            </div>
            @endif
            @if($notes->count())
            <div class="numOfNotes"><p>{{ $count }}件のノート</p></div>
            @else
            <div class="numOfNotes">
                <p>ノートが見つかりませんでした。</p>
            </div>
            @endif
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
        @include('layouts.web.footer')
    </body>
</html>
