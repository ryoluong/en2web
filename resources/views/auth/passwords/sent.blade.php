@extends('layouts.form')
@section('title', ' - Reset Password')
@section('content')
        <div id="registered_page">
            <div class="border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="text">
                            <p>Password reset link has been sent.</p>
                        </div>
                        <div class="link"></div>
                    </div>
                </div>
                <div class="content">
                    <div class="text_view">
                            <p class="card_text">入力いただいたメールアドレスにパスワードリセット用のリンクを送信いたしました。</p>
                            <p class="card_text">そちらに記載されているURLにアクセスし、パスワードの再設定を行ってください。</p>
                            <p class="card_text">※リンクは1時間のみ有効です。</p>
                    </div>
                </div>
            </div>
        </div>
@endsection