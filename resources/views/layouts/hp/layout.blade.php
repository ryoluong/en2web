<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>横国留学準備団体En2</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <link type="text/css" rel="stylesheet" href="{{ mix('css/en2hpstyle.css')}}">
        <script type="text/javascript" src="js/jquery-3.3.1.js"></script>
        <script type="text/javascript" src="js/jquery.bgswitcher.js"></script>
        <script>
            $(function(){
            $("#landing").bgswitcher({
                images: ["img/hp/landing_1.jpg","img/hp/landing_2.jpg","img/hp/landing_3.jpg", "img/hp/landing_4.jpg"],
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
                <div class="logo"><a href="/index"><img src="/img/hp/logo.png" alt="logo"></a></div>
                <div class="btn"><a href="/login" target="_blank">For members</a></div>
            </div>
                <!-- <ul class="menu">
                    <li><a href="/study_abroad">Study abroad</a></li>
                    <li class="splitter"><div></div></li>
                    <li><a href="/achievements">Achievements</a></li>
                    <li class="splitter"><div></div></li>
                    <li><a href="/about_us">About us</a></li>
                    <li class="splitter"><div></div></li>
                    <li><a href="/activities">Activities</a></li>
                    <li class="splitter"><div></div></li>
                    <li><a href="/join_contact">Join / Contact</a></li>
                </ul> -->
            <div class="dammy-menu"></div>
        </header>

        
        <main>
            @yield('main')
        </main>

        
        <footer>
            <p>copyright © 2018 En2. All rights reserved.</p>
        </footer>
    </body>
</html>
