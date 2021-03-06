@extends('layouts.app')
@section('title', ' - Notes')
@section('content')
<div id="app">
    <div class="content_head with_border">
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
    <form method="GET" action="/notes/search/result" onsubmit="disableButton()">
        <div class="search_wrapper">
            <input type="text" name="keywords" class="input_text" placeholder="Enter keyword" required>
            <button type ="submit" class="search_button" id="disable_button">Search</button>
        </div>
    </form>
    <div class="note_wrapper">
        <div class="category_wrapper">
            <a class="href" href="/notes/best">
            <img class="category_icon" src="/img/categories/best.png" alt="bestnotes">
            <p class="category_name">Best Notes</p>
            </a>
        </div>
        <ul class="note_list">
            @foreach($notes as $note)
            @include('layouts.web.notes')
            @endforeach
            <li class="note_item small_yellow">
                <a class="see_more" href="/notes/best"><p>See more</p></a>
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
                    <div class="image_wrapper" style="background-image:url({{ '/img/note_cover_photo/'.$category->id.'.jpg' }})">
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
        <div class="category_wrapper">
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
    <div class="buttons">
        <a class="purplebtn seeall" href="/notes/all">See all</a>
        <a class="bluebtn seeall" href="/notes/search">Search</a>
    </div>            
</div>
@endsection
