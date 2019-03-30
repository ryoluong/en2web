<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="mypage">
            <div class="content_head">
                <div class="icon">
                    @if($flag == 'mypage')
                    <img src="/img/top_mypage.png" alt="">
                    @else
                    <img src="/img/top_members.png" alt="">
                    @endif
                </div>
                <div class="text">
                    @if($flag == 'mypage')
                    <p>Mypage</p>
                    @else
                    <p>Members</p>
                    @endif
                </div>
                @if($flag == 'mypage')
                <a class="link" href="/mypage/edit">
                    <img src="/img/mypage_edit.png" alt="edit">
                </a>
                @else
                <a class="link" href="/users/{{ $id_previous }}">
                    @if($id_previous !== -1)
                    <img class="arrow" src="/img/back.png" alt="back">
                    @endif
                </a>
                <a class="link" href="/users/{{ $id_next }}">
                    @if($id_next !== -1)
                    <img class="arrow" src="/img/next.png" alt="next">
                    @endif
                </a>
                @endif
            </div>
            <div class="prof_top">
                @if($flag == 'mypage')
                <a class="cover" href="/mypage/upload_coverimg" style="background-image: url('{{ $user->coverimg_path !== null ? $user->coverimg_path : '/img/coverimg.jpeg' }}');"></a>
                <a class="user_icon_holder" href="/mypage/upload_avater">
                    <img class="user_icon" src="{{ $user->avater_path !== null ? $user->avater_path : '/img/categories/user.png' }}" alt="avater">
                </a>
                @else
                <div class="cover" style="background-image: url('{{ $user->coverimg_path !== null ? $user->coverimg_path : '/img/coverimg.jpeg' }}');"></div>
                <div class="user_icon_holder">
                    <img class="user_icon" src="{{ $user->avater_path !== null ? $user->avater_path : '/img/categories/user.png' }}" alt="avater">
                </div>
                @endif
                <div class="country_holder">
                    @if($user->countries->count())
                    @foreach($user->countries as $country)
                    <a class="user_country" href="/countries/{{ $country->id }}">
                        <img class="country_icon" src="/img/flags/{{ $country->english_name }}.png" alt="">
                    </a>
                    @endforeach
                    @endif
                    @if($user->isOverseas == 1)
                    <div class="status">留学中</div>
                    @endif
                    @if($user->isOB == 1)
                    <div class="status">OB･OG</div>
                    @endif
                    @if($user->status == 3)
                    <div class="status">未登録</div>
                    @endif
                </div>
            </div>
            <div class="no_border_card" style="margin-top:0;">
                <div class="content">
                    <p class="user_name">{{ $user->name }}</p>
                    @if($user->department !== null)
                    <p class="user_department">{{ $user->department.' '.$user->major }}</p>
                    @endif
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">入学年度</p></div>
                        <div class="value"><p>{{ $user->year }}</p></div>
                    </div>
                    <div class="prof_view">
                    <div class="property"><p class="prof_head">入会時期</p></div>
                        <div class="value"><p>{{ $user->generation }}期生</p></div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">留学先国</p></div>
                        <div class="value" style="display:block;">
                                @if($user->countries()->get() === null)
                                <p>{{ "(入力されていません)" }}</p>
                                @else
                                @foreach($user->countries()->get() as $country)
                                <p>{{ $country->name }}</p>
                                @endforeach
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">留学先</p></div>
                        <div class="value">
                            <p>
                                @if($user->status == 1)
                                {!! $user->university !!}
                                @else
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">就職・進路</p></div>
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
                            <div class="profile_text_value">
                                <p>
                                @if (!empty($user->profile))
                                {!! $user->profile !!}
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
                    <a class="href" href="/users/{{ $user->id }}/notes">
                        <img class="category_icon" src="/img/top_note.png" alt="">
                        @if($flag == 'mypage')
                        <p class="category_name">My Notes</p>
                        @else
                        <p class="category_name">
                            <?php
                                $name = preg_split('/\s/', $user->name, -1, PREG_SPLIT_NO_EMPTY);
                                echo htmlspecialchars($name[0], ENT_QUOTES, 'UTF-8')."'s Notes";
                            ?>
                        </p>
                        @endif
                    </a>
                </div>
                @if($user->notes->count())
                <ul class="note_list">
                    @foreach($notes as $note)
                    @include('layouts.web.notes')
                    @endforeach
                    @if($user->notes()->count() > 6)
                    <li class="note_item small">
                        <a class="see_more" href="/users/{{ $user->id }}/notes"><p class="see-more-text">See more</p></a>
                    </li>
                    @endif
                </ul>
                @else
                <p class="no_note">ノートがまだありません。</p>
                @endif
            </div>
            @if($flag == 'mypage')
            <div class="note_wrapper">
                <div class="category_wrapper">
                    <a class="href" href="/notes/like">
                        <img class="category_icon" src="/img/categories/like.png" alt="">
                        <p class="category_name">Liked Notes</p>
                    </a>
                </div>
                @if($favNotes->count())
                <ul class="note_list">
                    @foreach($favNotes as $note)
                    @include('layouts.web.notes')
                    @endforeach
                    @if($user->favNotes()->count() > 6)
                    <li class="note_item small">
                        <a class="see_more" href="/notes/like"><p class="see-more-text">See more</p></a>
                    </li>
                    @endif
                </ul>
                @else
                <p class="no_note">ノートがまだありません。</p>
                @endif
            </div>
            @endif
        </div>
        @include('layouts.web.footer')
    </body>
</html>
