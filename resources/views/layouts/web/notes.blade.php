<li class="note_item  {{ $note->isBest == 1 ? 'bestnote' : '' }}">
    <a href="/notes/{{ $note->id }}" class="note">
        <div class="image_holder" style="background-image:url(@if($note->photos->count()) {{ $note->photos->first()->path }} @else {{ '/img/note_cover_photo/'.$note->category_id.'.jpg' }} @endif);">
            <div class="textbox">
                <object><a class="note_category" href="/categories/{{ $note->category_id }}/notes">{{ $note->category->name }}</a></object>
                @if(auth()->user()->isAdmin === 1 || auth()->user()->id === $note->user_id)
                <object><a class="edit_icon" href="/notes/{{ $note->id }}/edit"><img class="edit_icon_image" src="/img/note_edit.png" alt=""></a></object>
                @endif
                <p class="note_title">{{ $note->title }}</p>  
                @foreach($note->countries as $country)
                <object><a class="note_country" href="/countries/{{ $country->id }}/notes">＠{{ $country->name }}</a></object>
                @endforeach
                @if($note->isBest == 1) 
                <object><p class="bestnote_icon" href="/notes/best">Best Note</p></object>
                @endif
                <div class="fav-button {{ auth()->user()->favNotes()->where('note_id', $note->id)->count() ? 'favNote' : '' }}">
                    <i class="fas fa-heart"><span>{{ $note->favUsers()->count() }}</span></i>
                </div>
            </div>
        </div>
        <div class="text_holder">
            <object>
                <a class="note_author" href="/users/{{ $note->user->id }}/notes">
                    <img class="author_icon" src="{{$note->user->avater_path !== null ? $note->user->avater_path : '/img/categories/user.png' }}" alt="">
                    <p class="author_name">{{ $note->user->name }}</p>
                </a>
            </object>
            <p class="note_date">{{ $note->date }}</p>
            <div class="description">
                <p class="note_content">
                <?php $temp = mb_substr($note->content, 0, 100).'......　';?>
                {{ $temp }}
                @foreach($note->tags as $tag)
                <object><a href="/tags/{{ $tag->id }}/notes"><span>{{ '#'.$tag->name }}</span></a></object>
                @endforeach
                </p>
            </div> 
        </div>
    </a>
</li>