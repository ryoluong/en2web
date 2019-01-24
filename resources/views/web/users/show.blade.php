<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="mypage">
        <div class="no_border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text">
                            <p class="user_name">{{ $user->name }}</p>
                            @if($user->countries->count())
                            @foreach($user->countries as $country)
                            <a class="user_country" href="/countries/{{ $country->id }}"><img src="/img/flags/{{ $country->english_name }}.png" alt=""></a>
                            @endforeach
                            @endif
                        </div>
                        <div class="link">
                            @if($id_previous !== -1)
                            <a href="/users/{{ $id_previous }}"><img class="arrow" src="/img/back.png" alt="back"></a>
                            @endif
                        </div>
                        <div class="link">
                            @if($id_next !== -1)
                            <a href="/users/{{ $id_next }}"><img class="arrow" src="/img/next.png" alt="next"></a>
                            @endif
                        </div>
                    </div>
 
                </div>
                <div class="content">
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">入学年度：</p></div>
                        <div class="value"><p>{{ isset($user->year) ? $user->year : "" }}</p></div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">学部：</p></div>
                        <div class="value"><p>{{ $user->department }}</p></div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">学科：</p></div>
                        <div class="value"><p>{{ $user->major }}</p></div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">入会時期：</p></div>
                        <div class="value"><p>{{ $user->generation }}期生</p></div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">留学先国：</p></div>
                        <div class="value">
                                @if($user->countries()->get() === null)
                                <p></p>
                                @else
                                @foreach($user->countries()->get() as $country)
                                <p>{{ $country->name }}&ensp;</p>
                                @endforeach
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">留学先：</p></div>
                        <div class="value">
                            <p>
                                @if($user->status == 1)
                                <?php echo nl2br(htmlspecialchars($user->university, ENT_QUOTES, 'UTF-8')); ?>
                                @else
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">OB・OG：</p></div>
                        <div class="value">
                            <p>
                                @if($user->status === 3)
                                {{ "" }}
                                @else
                                {{ $user->isOB ? "Yes" : "No" }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">就職・進路：</p></div>
                        <div class="value">
                            <p>
                                @if($user->status == 1)
                                {{ $user->job }}
                                @else
                                {{ "" }}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="prof_view">
                        <div class="line"></div>
                            <div class="profile_value">
                                <p>
                                @if (isset($user->profile))
                                <?php echo nl2br(htmlspecialchars($user->profile, ENT_QUOTES, 'UTF-8')); ?>
                                @else
                                {{ "（プロフィールが入力されていません）" }}
                                @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="note_wrapper">
                <div class="category_wrapper">
                    <img class="category_icon" src="/img/top_note.png" alt="">
                    <p class="category_name">
                        <?php
                            $name = preg_split('/\s/', $user->name, -1, PREG_SPLIT_NO_EMPTY);
                            echo htmlspecialchars($name[0], ENT_QUOTES, 'UTF-8')."'s Notes";
                        ?>
                    </p>
                </div>
                @if($user->notes->count())
                <ul class="note_list">
                    @foreach($notes as $note)
                    @include('layouts.web.notes')
                    @endforeach
                    @if($user->notes()->count() > 6)
                    <li class="note_item small">
                        <a class="see_more" href="/users/{{ $user->id }}/notes"><p>See more</p></a>
                    </li>
                    @endif
                </ul>
                @else
                <p class="no_note">ノートがまだありません。</p>
                @endif
            </div>
        </div>
        @include('layouts.web.footer')
    </body>
</html>
