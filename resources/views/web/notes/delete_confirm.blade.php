<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="delete_note">
        @if(auth()->user()->isAdmin === 1 || auth()->user()->id === $notes[0]->user_id)
            <form method="POST" action="/notes/{{ $note_id }}">
                {{ csrf_field() }} 
                {{ method_field('DELETE')}}
                <div class="no_border_card">
                    <div class="content">
                      <h2>以下のノートを本当に削除してもよろしいですか？</h2>
                        <ul class="note_view" style="justify-content: center;">
                            @foreach($notes as $note)
                            @include('layouts.web.notes')
                            @endforeach
                        </ul>
                    </div>
                    <div class="button_wrapper">
                        <button type="submit" class="redbtn">Delete</button>
                        <button type="button" onclick="history.back()" class="graybtn">Back</button>
                    </div>
                </div>
            </form>
        @endif
        </div>
    </body>
</html>
