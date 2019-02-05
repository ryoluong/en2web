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
                            <img class="img" src="/img/note_edit.png" alt="">
                        </a>
                    </div>
                    <div class="wrapper">
                    <p class="description">{{ "{$event->start->month}月{$event->start->day}日({$event->start->week}) {$event->start->time}-{$event->end->time}" }}</p>
                    @if(!empty($event->location))
                    <p class="description">{{ $event->location }}</p>
                    @endif
                    </div>
                </li>
                @endforeach
                @endif
                <li class="add">
                    <a class="button" href="/calendar/create">
                        <img class="icon" src="/img/plus_fff.png" alt="add"><p class="text">Add an Event</p>
                    </a>
                </li>
            </ul>
        </div>
        @include('layouts.web.footer')
    </body>
</html>
