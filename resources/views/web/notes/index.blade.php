<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="showNotes">
            <div class="content_head with_border_pc">
                <a class="icon" href="/notes">
                    <img src="/img/top_note.png" alt="note">
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
            <div class="note_wrapper">
                <div class="category_wrapper">
                    <a class="href" href="/best/notes">
                    <img class="category_icon" src="/img/categories/best.png" alt="bestnotes">
                    <p class="category_name">Best Notes</p>
                    </a>
                </div>
                <ul class="note_list">
                    @foreach($notes as $note)
                    @include('layouts.web.notes')
                    @endforeach
                    <li class="note_item small">
                        <a class="see_more" href="/best/notes"><p>See more</p></a>
                    </li>
                </ul>
            </div>
            <div class="note_wrapper">
                <div class="category_wrapper">
                    <img class="category_icon" src="/img/categories/category.png" alt="category">
                    <p class="category_name">Categories</p>
                </div>
                <ul class="note_list">
                    @foreach($categories as $category)
                    <li class="note_item category_item">
                        <a class="link_wrapper" href="/categories/{{ $category->id }}/notes">
                            <div class="image_wrapper" style="background-image:url({{ '/img/note/'.$category->id.'.jpg' }})">
                                <p class="category_name">{{ $category->name }}</p>
                            </div>
                            <div class="detail_wrapper">
                                <p class="category_detail">
                                @if($category->id === 1)
                                {{ '定番となった月一報告。みんなの活動をまとめて見よう。' }}
                                @elseif($category->id === 2)
                                {{ 'スコア取得に向けた勉強法や受験報告など。モチベアップ間違い無し！' }}
                                @elseif($category->id === 3)
                                {{ '留学準備で困ったらここをチェック！充実した情報を活用しよう。' }}
                                @elseif($category->id === 4)
                                {{ '多くの人が悩む就活。OBOGの仕事の話も読めちゃう！？' }}
                                @elseif($category->id === 5)
                                {{ '次に読む本を探そう。ネット記事の共有もこちらから！' }}
                                @else
                                {{ 'ベストノート最多のカテゴリ。みんなの考えを知ろう。' }}
                                @endif
                                </p>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="note_wrapper">
                <div class="category_wrapper" href="/bestnotes">
                    <img class="category_icon" src="/img/categories/tag.png" alt="bestnotes">
                    <p class="category_name">Tags</p>
                </div>
                <div class="tag_list_wrapper">
                    <ul class="note_list tag_list">
                        @foreach($tags as $tag)
                        <li class="tag_item" href="/tags/{{ $tag->id }}/notes"><a href="/tags/{{$tag->id}}/notes">{{ $tag->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="bluebtn seeall"><a href="/search/notes">Search notes</p></div>
            <div class="purplebtn seeall"><a href="/all/notes">See all notes</p></div>
        </div>
    </body>
</html>
