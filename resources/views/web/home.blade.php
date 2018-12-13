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
                    @if(strcmp($user_country,"中国") == 0 || strcmp($user_country,"香港") == 0 || strcmp($user_country,"台湾") == 0)
                        {{ "你好! " }}
                    @elseif(strcmp($user_country,"パラグアイ") == 0 || strcmp($user_country,"スペイン") == 0)
                        {{ "¡Hola! "}}
                    @elseif(strcmp($user_country,"フィリピン") == 0)
                        {{ "Magandang araw! " }}
                    @elseif(strcmp($user_country,"フィンランド") == 0)
                        {{ "Moi! " }}
                    @elseif(strcmp($user_country,"ドイツ") == 0)
                        {{ "Guten Tag! "}}
                    @elseif(strcmp($user_country,"ハンガリー") == 0)
                        {{ "Jó napot! "}}
                    @elseif(strcmp($user_country,"チェコ") == 0)
                        {{ "Dobrý den! "}}
                    @elseif(strcmp($user_country,"オランダ") == 0)
                        {{ "Goededag! " }}
                    @elseif(strcmp($user_country,"ベトナム") == 0)
                        {{ "Xin chào! "}}
                    @else
                        {{ "Hello! "}}
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
                        <a href="/countries">
                            <img src="/img/top_world.png" alt="countries">
                            <p>Countries</p>
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
                </tr>
            </table>
            <div class="logout">
                <a href=""{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <img src="/img/top_logout.png" alt="logout">
                    <p>Logout</p>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </a>
            </div>
        </div>
    </body>
</html>
