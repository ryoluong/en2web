<li class="item">
    <a href="/notes/{{ $note->id }}">
        <div class="note {{ $note->isBest == 1 ? 'bestnote' : '' }}">
            <div class="image_holder" style="background-image:url(
                @if($note->photos->count())
                @if(app()->isLocal())
                {{ '/storage'.$note->photos->first()->path }}
                @else
                {{ $note->photos->first()->path }}
                @endif
                @else
                {{ '/img/note/'.$note->category_id.'.jpg' }}
                @endif
            );">
                <div class="textbox">
                    <object><a class="note_category" href="/categories/{{ $note->category_id }}/notes">{{ $note->category->name }}</a></object>
                    <p class="note_title">{{ $note->title }}</p>         
                    @foreach($note->countries as $country)
                    <object><a class="note_country" href="/countries/{{ $country->id }}/notes">＠{{ $country->name }}</a></object>
                    @endforeach
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
</li>