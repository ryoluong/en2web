<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div class="content_head with_border">
            <a class="icon" href="/calendar">
                <img src="/img/top_calendar.png" alt="calendar">
            </a>
            <div class="text">
                <a href="/calendar">Calendar</a>
            </div>
            <a class="link" href="/calendar/create">
                <img src="/img/note_create.png" alt="">
            </a>
        </div>
        <div class="main">
            <iframe src="https://calendar.google.com/calendar/b/1/embed?showTitle=0&amp;showPrint=0&amp;showCalendars=0&amp;showTz=0&amp;height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=ok6ivv4869iegdf6fihbljum1o%40group.calendar.google.com&amp;color=%23865A5A&amp;ctz=Asia%2FTokyo" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
            <ul class="agenda">
                @if(!empty($events))
                @foreach($events as $event)
                <li class="event">
                    <div class="title">
                        <p class="text">{{ $event->getSummary() }}</p>
                        <a class="icon" href="/calendar/{{ $event->getId() }}">
                            <img class="img" src="/img/mypage_edit.png" alt="">
                        </a>
                    </div>
                    <div class="wrapper">
                    <p class="description">{{ $event->when }}</p>
                    @if(!empty($event->location))
                    <p class="description">{{ $event->location }}</p>
                    @endif
                    </div>
                </li>
                @endforeach
                @endif
                <li class="add">
                    <a class="button" href="/calendar/create">
                        <svg class="icon" viewBox="0 0 36 36">
                            <path fill="#34A853" d="M16 16v14h4V20z"></path>
                            <path fill="#4285F4" d="M30 16H20l-4 4h14z"></path>
                            <path fill="#FBBC05" d="M6 16v4h10l4-4z"></path>
                            <path fill="#EA4335" d="M20 16V6h-4v14z"></path>
                            <path fill="none" d="M0 0h36v36H0z"></path>
                        </svg>
                        <p class="text">Add an Event</p>
                    </a>                
                </li>
            </ul>
        </div>
        @include('layouts.web.footer')
    </body>
</html>
