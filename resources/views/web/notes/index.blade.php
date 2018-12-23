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
                </div>
                <div class="note_wrapper">
                    <a class="category_wrapper" href="/bestnotes">
                        <img class="category_icon" src="/img/categories/best.png" alt="bestnotes">
                        <p class="category_name">Best Notes</p>
                    </a>
                    <ul class="note_list">
                        @foreach($notes->where('isBest', true)->take(6) as $note)
                        @include('layouts.web.notes')
                        @endforeach
                        <li class="note_item small">
                            <a class="see_more" href="/bestnotes"><p>See more</p></a>
                        </li>
                    </ul>
                </div>
                
                @foreach($categories as $category)
                <div class="note_wrapper">
                    <a class="category_wrapper" href="/categories/{{ $category->id }}/notes">
                        <img class="category_icon" src="/img/categories/category{{ $category->id }}.png" alt="">
                        <p class="category_name">{{ $category->name }}</p>
                    </a>
                    <ul class="note_list">
                        @foreach($notes->where('category_id', $category->id)->take(6) as $note)
                        @include('layouts.web.notes')
                        @endforeach
                        <li class="note_item small">
                            <a class="see_more" href="categories/{{ $category->id }}/notes"><p>See more</p></a>
                        </li>
                    </ul>
                </div>
                @endforeach
        </div>
    </body>
</html>
