@extends('layouts.app')
@section('content')
<div class="how-to-register">
    <h5>En2::WebはEn2メンバー専用のWebサイトです。メンバー以外の登録・ログインはできません。</h5>
    <h1>登録方法</h1>
    <h2>1. <a href="/login" target="_blank">en2ynu.com</a>にアクセス</h2>
    <h2>2. Sign upをクリック</h2>
    <img class="img" src="/img/register/img1.png" alt="img1">
    <h2>3. 必要項目を入力</h2>
    <img src="/img/register/img2.png" alt="img2" class="img">
    <h2>4. 記入事項を確認して送信</h2>
    <img src="/img/register/img3.png" alt="img3" class="img">
    <h2>5. 届いたメールのリンクをクリックし、登録を続けてください。</h2>
    <img src="/img/register/img5.png" alt="img5" class="img">
    <h3><strong>！登録時に下記の画面が表示された場合</strong></h3>
    <h4>- メールアドレスの記入に間違いがあった可能性が高いです。再登録してください。</h4>
    <p>*コードは同一のものが使えます。</p>
    <img src="/img/register/img4.png" alt="img4" class="img">
    <h3><strong>！メールが届かない場合</strong></h3>
    <h4>- 上記同様、メールアドレスに間違いがあった可能性があります。再登録してください。</h4>
    <h4>- 迷惑メールボックスを確認してください。en2ynu.comドメインのメールがフィルターに引っかかることがあります。</h4>
    <h4>- YNUアドレスでメールが届かない場合は、Gmailなど他のアドレスで登録を行ってみてください。</h4>
</div>
@endsection