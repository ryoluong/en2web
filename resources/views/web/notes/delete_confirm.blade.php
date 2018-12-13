<!doctype html>
<html lang=jp">
    <head>
        @include('layouts.web.head')
    </head>
    <body>
        @include('layouts.web.header')
        <div id="delete_note">
        @if(auth()->user()->isAdmin === 1)
            
            <form method="POST" action="/notes/{{ $note->id }}">
                {{ csrf_field() }} 
                {{ method_field('DELETE')}}
                
                <div class="no_border_card">
                    <div class="content">
                    <h2>以下のノートを本当に削除してもよろしいですか？</h2>
                        <div class="note_view">
                           <a href="/notes/{{ $note->id }}">
                                <div class="note {{ $note->isBest == 1 ? 'bestnote' : '' }}">
                                    <div class="image_holder"style="background-image:url({{ $note->photos->count() ? $note->photos->first()->path : '/storage/img/note/no_image.jpg' }});">
                                        <div class="textbox">
                                            <object><a class="note_category" href="/categories/{{ $note->category_id }}/notes">{{ $note->category->name }}</a></object>
                                            <p class="note_title">{{ $note->title }}</p>         
                                            @foreach($note->countries as $country)
                                            <p class="note_country">＠{{ $country->name }}</p>
                                            @endforeach
                                            <object><a class="note_author" href="/users/{{ $note->user->id }}/notes">{{ $note->user->name }}</a></object>
                                            <p class="note_date">{{ $note->date }}</p>
                                            @if($note->isBest == 1) 
                                            <p class="bestnote_icon"><img src="/img/best_note.png" alt=""></p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="description">
                                        <p class="note_content">
                                        <?php $temp = mb_substr($note->content, 0, 110).'......　';?>
                                        {{ $temp }}
                                        @foreach($note->tags as $tag)
                                        <object><a href="/tags/{{ $tag->id }}/notes"><span>{{ '#'.$tag->name }}</span></a></object>
                                        @endforeach
                                        </p>
                                    </div>
                                </div>    
                            </a>              
                        </div>
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
