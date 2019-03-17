<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="app">
            <div id="showMembers">
                <div class="content_head with_border">
                    <div class="icon">
                        <img src="img/top_members.png" alt="members">
                    </div>
                    <div class="text">
                        <p>Members</p>
                    </div>
                </div>
                <form>
                <div class="search_wrapper">
                    <input type="text" v-model="search" class="input_text" placeholder="Search members">
                </div>
                </form>
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
                            <users-item :user="{{ $user }}" :search="search"></users-item>
                        @endforeach
                    </div>
                    @endfor
                </div>    
            </div>
            @include('layouts.web.footer')
        </div>
        <script src=" {{ mix('js/app.js') }} "></script>
    </body>
</html>
