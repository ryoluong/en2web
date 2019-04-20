@extends('layouts.app')
@section('content')
<div class="content_head with_border">
    <a class="icon" href="/users">
        <img src="img/top_members.png" alt="members">
    </a>
    <div class="text">
        <a href="/users">Members</a>
    </div>
</div>
<div class="loading-wrapper" v-show="loading">
    <div class="loading"></div>
</div>
<users-index :users="{{ $users }}" v-show="!loading"></users-index>
@endsection
