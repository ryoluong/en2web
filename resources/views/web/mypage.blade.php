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
                        <div class="icon">
                            <img src="img/top_mypage.png" alt="">
                        </div>
                        <div class="text"><p>{{ $user->name }}</p></div>
                        <div class="link">
                            <a href="/mypage/edit">
                                <img src="/img/mypage_edit.png" alt="edit">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">入学年度：</p></div>
                        <div class="value"><p>{{ isset($user->year) ? $user->year : "(入力されていません)" }}</p></div>
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
                                <p>{{ "(入力されていません)" }}</p>
                                @else
                                @foreach($user->countries()->get() as $country)
                                <p>{{ $country->name."　" }}</p>
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
                                    {{ $user->university }}
                                @else
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="prof_view">
                        <div class="property"><p class="prof_head">OB・OG：</p></div>
                        <div class="value"><p>{{ $user->isOB ? "Yes" : "No" }}</p></div>
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
            <div class="no_border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="icon">
                            <img src="img/top_note.png" alt="">
                        </div>
                        <div class="text"><p>My Notes</p></div>
                        <div class="link"></div>
                    </div>
                </div>
                <div class="content">
                    @if($user->notes->count())
                        @include('layouts.web.notes')
                    @else
                    <p class="no_note">まだノートがありません。</p>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
