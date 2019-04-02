<header>
    <div id="web_header">
        <div class="header-upper">
            @auth
            <div class="element burger-button sp" @click="toggleShowMenu">
                <div class="el colored"></div>
                <div class="el"></div>
                <div class="el colored"></div>
                <div class="el"></div>
                <div class="el colored"></div>
            </div>
            <div class="element pc"></div>
            <a href="/home">
                <img class="logo" src="/img/top_logo.png" alt="header_logo">
            </a>
            <div class="element avater sp" @click="toggleShowUserMenu">
                <img class="icon" src="{{ auth()->user()->avater_path !== null ? auth()->user()->avater_path : '/img/categories/user.png' }}" alt="user_icon">
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <a class="pc" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <img class="element" src="/img/top_logout.png" alt="logout">
            </a>
            @else
            <div class="element"></div>
            <a href="/home">
                <img class="logo" src="/img/top_logo.png" alt="header_logo">
            </a>
            <div class="element"></div>
            @endauth
        </div>
        @auth
        <transition name="slide">
            <div class="slide-menu sp" v-bind:class="{ show: showMenu }" v-if="showMenu">
                <ul class="menu-wrapper">
                    <li class="menu-content">
                        <a class="link" href="/mypage">
                            <img class="link_img" src="/img/top_mypage.png" alt="">
                            <p class="link_text">Mypage</p>
                        </a>
                    </li>
                    <li class="menu-content">
                        <a class="link" href="/notes">
                            <img class="link_img" src="/img/top_note.png" alt="">
                            <p class="link_text">Notes</p>
                        </a>
                    </li>
                    <li class="menu-content">
                        <a class="link" href="/users">
                            <img class="link_img" src="/img/top_members.png" alt="">
                            <p class="link_text">Members</p>
                        </a>
                    </li>
                    <li class="menu-content">
                        <a class="link" href="/countries">
                            <img class="link_img" src="/img/top_world.png" alt="">
                            <p class="link_text">Countries</p>
                        </a>
                    </li>
                    <li class="menu-content">
                        <a class="link" href="/calendar">
                            <img class="link_img" src="/img/top_calendar.png" alt="">
                            <p class="link_text">Calendar</p>
                        </a>
                    </li>
                    <li class="menu-content">
                        <a class="link" href="/support">
                            <img class="link_img" src="/img/top_support.png" alt="">
                            <p class="link_text">Support</p>
                        </a>
                    </li>
                </ul>
            </div>
        </transition>
        @endauth
    </div>
    @auth
        <ul class="menu pc">
            <li class="menu_content"><a href="/mypage">Mypage</a></li>
            <li class="splitter"><div></div></li>
            <li class="menu_content"><a href="/countries">Countries</a></li>
            <li class="splitter"><div></div></li>
            <li class="menu_content"><a href="/notes">Notes</a></li>
            <li class="splitter"><div></div></li>
            <li class="menu_content"><a href="/users">Members</a></li>
        </ul>
    @else
    <div class="dammy_menu pc"></div>
    @endauth
</header>
@auth
<transition name="fade">
    <ul class="user-menu" v-bind:class="{ show: showUserMenu }" v-if="showUserMenu">
        <li class="list"><p class="user-name">{{ auth()->user()->name }}</p></li>
        <li class="list"><a href="/mypage" class="link">Mypage</a></li>
        <li class="list"><a href="/mypage/edit" class="link">Edit profile</a></li>
        <li class="list"><a href="/mypage/upload_avater" class="link">Edit user photo</a></li>
        <li class="list"><a class="link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
    </ul>
</transition>
<div class="below_slide_menu" v-if="showMenu" @click="toggleShowMenu"></div>
@endauth