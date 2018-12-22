<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div class="country_show">
            <div class="no_border_card">
                <div class="title border_none">
                    <div class="table_view">
                        <div class="text">
                            <img class="country_flag" src="/img/flags/{{ $country->english_name }}.png" alt="flag">
                            <p class="country_name">{{ $country->name }}</p>
                        </div>
                    </div>
                </div>
                <div class="title">
                    <div class="table_view">
                        <div class="icon">
                            <img src="/img/top_members.png" alt="members">
                        </div>
                        <div class="text">
                            <p>
                            {{ 'Members' }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="users">
                        @if($country->users->count())
                        @foreach($country->users as $user)
                        <div class="form_view">
                            <div class="property"><a href="/users/{{ $user->id }}">{{ $user->name }}</a></div>
                            <p class="value">{{ $user->university }}</p>
                        </div>
                        @endforeach
                        @else
                        <p class="no_note">まだメンバーがいません。</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="note_wrapper">
                <div class="category_wrapper">
                    <img class="category_icon" src="/img/top_note.png" alt="">
                    <p class="category_name">Notes</p>
                </div>
                @if($country->notes->count())
                <ul class="note_list">
                    @foreach($notes as $note)
                    @include('layouts.web.notes')
                    @endforeach
                    @if($country->notes->count() > 6)
                    <li class="note_item small">
                        <a class="see_more" href="users/{{ $user->id }}/notes"><p>See more</p></a>
                    </li>
                    @endif
                </ul>
                @else
                <p class="no_note">ノートがまだありません。</p>
                @endif
            </div>
        </div>    
    </body>
</html>