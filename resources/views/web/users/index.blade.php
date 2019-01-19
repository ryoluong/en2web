<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="showMembers">
            <div class="content_head with_border">
                <div class="icon">
                    <img src="img/top_members.png" alt="members">
                </div>
                <div class="text">
                    <p>Members</p>
                </div>
            </div>
            <div class="no_border_card">
                @for($i = 1; $i <= $max; $i++)
                <div class="flex_container">
                    <div class="subtitle">
                    <p>
                        @if($i % 10 === 1)
                        {{ $i."st" }}
                        @elseif($i % 10 === 2)
                        {{ $i."nd" }}
                        @elseif($i % 10 === 3)
                        {{ $i."rd" }}
                        @else
                        {{ $i."th" }}
                        @endif
                    </p>
                    </div>
                    @foreach($users->where('generation', $i) as $user)
                    <div class="flex_view">
                        <a href="/users/{{ $user->id }}"><img class="user_icon" src="{{ $user->avater_path !== null ? $user->avater_path : '/img/categories/user.png' }}" alt="user_icon"></a>
                        <a class="user_name" href="/users/{{ $user->id }}">{{ $user->name }}</a>
                    </div>
                    @endforeach
                </div>
                @endfor
            </div>    
        </div>
    </body>
</html>
