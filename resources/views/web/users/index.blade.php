<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="showMembers">
            <div class="no_border_card">
                <div class="title">
                    <div class="table_view">
                        <div class="icon">
                            <img src="img/top_members.png" alt="">
                        </div>
                        <div class="text"><p>Members</p></div>
                    </div>
                </div>
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
                        <a class="user_name" href="users/{{ $user->id }}"><p class="user_name">{{ $user->name }}</p></a>
                    </div>
                    @endforeach
                </div>
                @endfor
            </div>    
        </div>
    </body>
</html>
