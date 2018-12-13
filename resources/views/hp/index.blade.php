@extends('layouts.hp.layout')

@section('main')
<div class="landing" id="landing">
    <h1 id="landing-text">本気で、<br>留学をしないか。</h1>
</div>
<div class="main">
    <div class="about_us">
    <h1><span>A</span>bout us</h1>
    </div>
    <div class="description">
    <h2><span>本気</span>になりたい人が、本気になれる場所。</h2>
    <p>En2（エンツー）は横浜国立大学で唯一の、</p>
    <p>留学志望者・経験者が集まる大学公認団体です。</p>
    <p>交換留学をはじめ、海外インターン・研究留学・海外院進など、</p>
    <p>様々な形で海外を目指すメンバーが数多く在籍しています。</p>
    <p>
        <input class="button" type="button" value="詳しくみる" onclick="location.herf=''">
    </p>
    </div>
</div>
<div class="main">
    <div class="achievements">
    <h1><span>A</span>chievements</h1>
    </div>
    <div class="description">
    <h2><span>英米</span>から、パラグアイまで。</h2>
    <p>過去3年の留学者数は20人超、渡航先は実に12カ国以上。</p>
    <!--アイコンはここから https://www.iconfinder.com/iconsets/195-flat-flag-psd-icons-->
    <table class="countries">
        <tr class="name">
            <td>U.S.</td>
            <td>U.K.</td>
            <td>Germany</td>
            <td>Finland</td>
        </tr>
        <tr class="icon">
            <td><img src="img/us.png"></td>
            <td><img src="img/uk.png"></td>
            <td><img src="img/germany.png"></td>
            <td><img src="img/finland.png"></td>
        </tr>
        <tr class="name">
            <td>Hungary</td>
            <td>Australia</td>
            <td>Newzealand</td>
            <td>China</td>
        </tr>
        <tr class="icon">
            <td><img src="img/hungary.png"></td>
            <td><img src="img/australia.png"></td>
            <td><img src="img/newzealand.png"></td>
            <td><img src="img/china.png"></td>
        </tr>
        <tr class="name">
            <td>Taiwan</td>
            <td>Vietnam</td>
            <td>Paraguay</td>
            <td>Tonga</td>
        </tr>
        <tr class="icon">
            <td><img src="img/taiwan.png"></td>
            <td><img src="img/vietnam.png"></td>
            <td><img src="img/paraguay.png"></td>
            <td><img src="img/tonga.png"></td>
        </tr>
    </table>
    <p>
        <input class="button" type="button" value="詳しくみる" onclick="location.herf=''">
    </p>
    </div>
</div>
<div class="main">
    <div class="activities">
    <h1><span>A</span>ctivities</h1>
    </div>
    <div class="description">
    <h2><span>留学</span>の好循環を実現する。</h2>
    <p>En2ではTOEFL iBT・IELTSの英語試験対策をはじめとして、</p>
    <p>留学中の学生による定期報告、奨学金や留学情報の共有等を行っています。</p>
    <p>縦横の繋がりを生かして様々な相談や質問ができるのはもちろん、</p>
    <p>ショートビジット・プログラムにメンバーで誘い合って申し込んだり、</p>
    <p>自身の関心のある分野の勉強に取り組むことも可能です。</p>
    <input class="button" type="button" value="詳しくみる">
    </div>
</div>
<div class="main">
    <div class="andmore">
    <h1><span>A</span>nd more...</h1>
    </div>
    <div class="description">
    <ul>
        <li><a href="study_abroad.html">
        <h3 class="link1">留学情報</h3>
        <p>横国生向け・留学情報はこちら</p></a>
        </li>
        <li><a href="join_contact.html">
        <h3 class="link2">加入・コンタクト</h3>
        <p>お問い合わせ・加入希望の方はこちら</p></a>
        </li>
    </ul>
    </div>
</div>
@endsection