<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        <div id="home">
            <div class="top_logo">
                <img src="img/top_logo.png" alt="en2web-logo">
                <p>
                @if(auth()->user()->countries()->count())
                    @if(auth()->user()->countries()->first()->name == "中国" || auth()->user()->countries()->first()->name == "香港" || auth()->user()->countries()->first()->name == "台湾")
                        {{ "你好! " }}
                    @elseif(auth()->user()->countries()->first()->name == "パラグアイ" || auth()->user()->countries()->first()->name == "スペイン")
                        {{ "¡Hola! "}}
                    @elseif(auth()->user()->countries()->first()->name == "フィリピン")
                        {{ "Magandang araw! " }}
                    @elseif(auth()->user()->countries()->first()->name == "フィンランド")
                        {{ "Moi! " }}
                    @elseif(auth()->user()->countries()->first()->name == "ドイツ")
                        {{ "Guten Tag! "}}
                    @elseif(auth()->user()->countries()->first()->name == "ハンガリー")
                        {{ "Jó napot! "}}
                    @elseif(auth()->user()->countries()->first()->name == "チェコ")
                        {{ "Dobrý den! "}}
                    @elseif(auth()->user()->countries()->first()->name == "オランダ")
                        {{ "Goededag! " }}
                    @elseif(auth()->user()->countries()->first()->name == "ベトナム")
                        {{ "Xin chào! "}}
                    @else
                        {{ "Hello! "}}
                    @endif
                @else
                    {{ "Hello! " }}
                @endif
                    {{ auth()->user()->name }}
                </p>
            </div>
            <table class="icon_table">
                <tr class="icon_tr">
                    <td class="icon_td">
                        <a href="/mypage">
                            <img src="/img/top_mypage.png" alt="mypage">
                            <p>Mypage</p>
                        </a>
                    </td>
                    <td class="icon_td">
                        <a href="/notes">
                            <img src="/img/top_note.png" alt="note">
                            <p>Notes</p>
                        </a>
                    </td>
                    <td class="icon_td">
                        <a href="/users">
                            <img src="/img/top_members.png" alt="members">
                            <p>Members</p>
                        </a>
                    </td>
                    <td class="icon_td">
                        <a href="/countries">
                            <img src="/img/top_world.png" alt="countries">
                            <p>Countries</p>
                        </a>
                    </td>                    
                    <td class="icon_td">
                        <a href="/calendar">
                            <img src="/img/top_calendar.png" alt="calendar">
                            <p>Calendar</p>
                        </a>
                    </td>
                    <td class="icon_td">
                        <a href="/support">
                            <img src="/img/top_support.png" alt="support">
                            <p>Support</p>
                        </a>
                    </td>
                </tr>
            </table>
            <a class="logout" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img class="icon" src="/img/top_logout.png" alt="logout">
                <p class="text">Logout</p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </a>
            @if($show_attendance_button)
                <div class="attendance_notice">
                    <form method="POST" action="/attend" onsubmit="disableButton();">
                        @csrf
                        <div class="radio-wrapper">
                            <input class="input-radio" id="attend" type="radio" name="status" value="attend" checked><label class="label-radio" for="attend">出席</label>
                            <input class="input-radio" id="late" type="radio" name="status" value="late"><label class="label-radio" for="late">遅刻</label>
                            <input class="input-radio" id="early" type="radio" name="status" value="early"><label class="label-radio" for="early">早退</label>
                        </div>
                        <button class="bluebtn" type="submit">送信</button>
                    </form>
                </div>
            @endif
        </div>
    </body>
</html>
