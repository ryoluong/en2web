<header>
    <div id="web_header">
        <div>
            <a class="elements"></a>
        </div>
        <a href="/home">
            <img class="logo" src="/img/top_logo.png" alt="header_logo">
        </a>
        <div>
        @guest
        <a class="elements"></a>
        @else
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <img class="elements" src="/img/top_logout.png" alt="logout">
        </a>
        @endguest
        </div>
    </div>
    @guest
        <div class="dammy_menu"></div>
    @else
        <ul class="menu">
            <li class="menu_content"><a href="/mypage">Mypage</a></li>
            <li class="splitter"><div></div></li>
            <li class="menu_content"><a href="/countries">Countries</a></li>
            <li class="splitter"><div></div></li>
            <li class="menu_content"><a href="/notes">Notes</a></li>
            <li class="splitter"><div></div></li>
            <li class="menu_content"><a href="/users">Members</a></li>
        </ul>
    @endguest
</header>