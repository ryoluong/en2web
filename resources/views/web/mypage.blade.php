@extends('layouts.app')
@section('title', ' - Mypage')
@section('script')
<script>
    function openTwitter(id) {
        if (window.confirm('Twitterを開きますか？')) {
            window.open('/open/twitter/' + id, 'newtab');
        }
    }
    function openInstagram(id) {
        if(window.confirm('Instagramを開きますか？')) {
            window.open('/open/instagram/' + id, 'newtab');
        }
    }
</script>
@endsection
@section('content')
<div id="mypage">
    <div class="content_head">
        @if($flag == 'mypage')
        <div class="icon">
            <img src="/img/top_mypage.png" alt="">
        </div>
        @else
        <a href="/users" class="icon">
            <img src="/img/top_members.png" alt="">
        </a>
        @endif
        <div class="text">
            @if($flag == 'mypage')
            <p>Mypage</p>
            @else
            <a href="/users">Members</a>
            @endif
        </div>
        @if($flag == 'mypage')
        <a class="link" href="/mypage/edit">
            <img src="/img/mypage_edit.png" alt="edit">
        </a>
        @else
        @if($id_previous !== -1)
        <a class="link" href="/users/{{ $id_previous }}{{ $queries ? $queries : '' }}">
            <img class="arrow" src="/img/back.png" alt="back">
        </a>
        @else
        <p class="link"></p>
        @endif
        @if($id_next !== -1)
        <a class="link" href="/users/{{ $id_next }}{{ $queries ? $queries : '' }}">
            <img class="arrow" src="/img/next.png" alt="next">
        </a>
        @else
        <p class="link"></p>
        @endif
        @endif
    </div>
    <div class="prof_top">
        @if($flag == 'mypage')
        <a class="cover" href="/mypage/upload_coverimg"
            style="background-image: url('{{ $user->coverimg_path !== null ? $user->coverimg_path : '/img/coverimg.jpeg' }}');"></a>
        <a class="user_icon_holder" href="/mypage/upload_avater">
            <img class="user_icon"
                src="{{ $user->avater_path !== null ? $user->avater_path : '/img/categories/user.png' }}" alt="avater">
        </a>
        @else
        <div class="cover"
            style="background-image: url('{{ $user->coverimg_path !== null ? $user->coverimg_path : '/img/coverimg.jpeg' }}');">
        </div>
        <div class="user_icon_holder">
            <img class="user_icon"
                src="{{ $user->avater_path !== null ? $user->avater_path : '/img/categories/user.png' }}" alt="avater">
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
            @if($user->instagram_id || $user->twitter_id)
            <div class="sns-links">
                @if($user->instagram_id)
                <img class="sns-icon" src="/img/sns/instagram.png" alt="twitter_icon" onclick="openInstagram({{ json_encode($user->instagram_id) }})">
                @endif
                @if($user->twitter_id)
                <img class="sns-icon" src="/img/sns/twitter.png" alt="instagram_icon" onclick="openTwitter({{ json_encode($user->twitter_id) }})">
                @endif
            </div>
            @endif
            <div class="user-profile">
                <div class="property"><i class="fas fa-user-friends"></i></div>
                <div class="value">
                    <p class="value-text">
                        {{ empty($user->year) ? '' : $user->year . '年入学・' }}{{ $user->generation }}期生
                    </p>
                </div>
            </div>
            @if($user->countries->count())
            <div class="user-profile">
                <div class="property"><i class="fas fa-globe-asia"></i></div>
                <div class="value">
                    <p class="value-text">
                        @foreach($user->countries()->get() as $country)
                        {{ $country->name.' ' }}
                        @endforeach
                    </p>
                </div>
            </div>
            @endif
            @if(!empty($user->university))
            <div class="user-profile">
                <div class="property"><i class="fas fa-graduation-cap"></i></div>
                <div class="value">
                    <p class="value-text">
                        {!! $user->university !!}
                    </p>
                </div>
            </div>
            @endif
            @if(!empty($user->job))
            <div class="user-profile">
                <div class="property"><i class="fas fa-briefcase"></i></div>
                <div class="value">
                    <p class="value-text">
                        {{ $user->job }}
                    </p>
                </div>
            </div>
            @endif
            @if ($flag == 'mypage')
            <button onclick="location.href='/mypage/edit'" class="edit-link bluebtn">プロフィールを編集する</button>
            @else
            <div class="line"></div>
            @endif
            <div class="user-profile">
                <div class="profile-long-text">
                    @if ($flag == 'mypage' && empty($user->avater_path))
                    <div class="prof-alert">
                        <i class="fas fa-exclamation"></i>
                        <p class="text">アイコンが設定されていません</p>
                    </div>
                    @endif
                    @if (!empty($user->profile))
                    <p class="text">{!! $user->profile !!}</p>
                    @elseif ($flag == 'mypage')
                    <div class="prof-alert">
                        <i class="fas fa-exclamation"></i>
                        <p class="text">自己紹介文が入力されていません</p>
                    </div>
                    @else
                    <p class="no-text">{{ "（プロフィールが未記入です）" }}</p>
                    @endif
                    </p>
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
                <a class="see_more" href="/users/{{ $user->id }}/notes">
                    <p class="see-more-text">See more</p>
                </a>
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
                <a class="see_more" href="/notes/like">
                    <p class="see-more-text">See more</p>
                </a>
            </li>
            @endif
        </ul>
        @else
        <p class="no_note">ノートがまだありません。</p>
        @endif
    </div>
    @endif
</div>
@endsection