<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="country_show">
            <div class="no_border_card">
                <div class="title">
                    <div class="table_view">
                        <p class="icon" href="/countries">
                            <img src="/img/flags/{{ $country->english_name }}.png" alt="note">
                        </p>
                        <div class="text">
                            <p>
                            {{ $country->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="note_wrapper">
                <div class="category_wrapper">
                    <img src="/img/top_members.png" alt="" class="category_icon">
                    <p class="category_name">Members</p>
                </div>
                @if($country->users->count())
                <ul class="member_list">
                    @foreach($country->users as $user)
                    <li class="member_item">
                        <a class="linker" href="/users/{{ $user->id }}">
                            <p class="user_name">{{ $user->name }}</p>
                            <p class="user_university">{{ $user->generation.'期生' }}</p>
                            <p class="user_university">{{ $user->department }}</p>
                            <p class="user_university">
                                <?php echo nl2br(htmlspecialchars($user->university, ENT_QUOTES, 'UTF-8')); ?>
                            </p>
                        </a>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="no_note">まだメンバーがいません。</p>
                @endif
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
                        <a class="see_more" href="countries/{{ $country->id }}/notes"><p>See more</p></a>
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