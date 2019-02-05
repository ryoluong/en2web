<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>横国留学準備団体En2</title>
        <link type="text/css" rel="stylesheet" href="css/hp_stylesheet.css">
        <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="js/jquery.bgswitcher.js"></script>
        <script>
            $(function(){
            $("#landing").bgswitcher({
                images: ["img/landing_1.jpg","img/landing_2.jpg","img/landing_3.jpg", "img/landing_4.jpg"],
                interval: 2500,
                effect: "fade",
                duration: 1000,
                easing: "linear"
            });
            $("#landing-text").fadeIn(500);
            });
        </script>
    </head>
    <body>
        <header>
            <div class="headerTop">
                <div class="blank"><a href=""></a></div>
                <div class="logo"><a href="/"><img src="img/logo.png" alt="logo"></a></div>
                <div class="btn"><a href="/login" target="_blank">For members</a></div>
            </div>
                <ul class="menu">
                    <li><a href="/study_abroad">Study abroad</a></li>
                    <li class="splitter"><div></div></li>
                    <li><a href="/achievements">Achievements</a></li>
                    <li class="splitter"><div></div></li>
                    <li><a href="/about_us">About us</a></li>
                    <li class="splitter"><div></div></li>
                    <li><a href="/activities">Activities</a></li>
                    <li class="splitter"><div></div></li>
                    <li><a href="/join_contact">Join / Contact</a></li>
                </ul>
        </header>

        
        <main>
            @yield('main')
        </main>

        
        <footer>
            <ul class="footer-menu">
                <li><a href="/study_abroad">Study abroad</a></li>
                <li><a href="/achievements">Achievements</a></li>
                <li><a href="/">Home</a></li>
                <li><a href="/about_us">About us</a></li>
                <li><a href="/activities">Activities</a></li>
                <li><a href="/join_contact">Join / Contact</a></li>
            </ul>
            <p>copyright © 2018 En2. All rights reserved.</p>
        </footer>
    </body>
</html>
