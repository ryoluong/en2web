@extends('layouts.app')
@section('content')
<div class="content_head with_border">
    <div class="icon">
        <img src="img/top_members.png" alt="members">
    </div>
    <div class="text">
        <p>Members</p>
    </div>
</div>
<div class="loading-wrapper" v-show="loading">
    <div class="loading"></div>
</div>
<users-index :users="{{ $users }}" :max="{{ $max }}" v-show="!loading"></users-index>
@endsection
