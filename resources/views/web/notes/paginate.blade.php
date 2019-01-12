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
                            <a href="/search/notes">
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
                        <img class="category_icon" src="/img/categories/user.png" alt="user">
                        <p class="category_name">{{ $user->name }}</p>
                        <a class="link" href="/users/{{ $user->id }}">See profile</a>
                    </div>
                    @elseif($flag =='country')
                    <div class="category_wrapper">
                        <img class="category_icon" src="/img/flags/{{ $country->english_name }}.png" alt="country">
                        <p class="category_name">{{ $country->name }}</p>
                        <a class="link" href="/countries/{{ $country->id }}">See country</a>
                    </div>
                    @else
                    <div class="category_wrapper">
                        <img class="category_icon" src="/img/categories/allnotes.png" alt="all notes">
                        <p class="category_name">全てのノート</p>
                    </div>
                    @endif
                    <p class="numOfNotes">{{ $count }}件のノート</p>
                    <div class="sp">{{ $notes->links() }}</div>
                    <ul class="note_view">
                    @foreach($notes as $note)
                    @include('layouts.web.notes')
                    @endforeach    
                    </ul>
                    {{ $notes->links() }}
                </div>
            </div>
        </div>
    </body>
</html>
