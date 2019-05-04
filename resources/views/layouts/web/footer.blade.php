<footer>
    @guest
    @else
    <ul class="footer_menu">
        <li class="menu_list"><a href="/mypage" class="menu_link">Mypage</a></li>
        <li class="menu_list"><a href="/" class="menu_link">Home</a></li>
        <li class="menu_list"><a href="/notes" class="menu_link">Notes</a></li>
        <li class="menu_list"><a href="/users" class="menu_link">Members</a></li>
        <li class="menu_list"><a href="/countries" class="menu_link">Countries</a></li>
        <li class="menu_list"><a href="/calendar" class="menu_link">Calendar</a></li>
    </ul>
    @endguest
    <p class="copyright">© 2019 En2. All rights reserved.</p>
</footer>
<script src=" {{ mix('js/app.js') }} "></script>