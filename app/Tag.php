<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = [
        'id',
    ];

    public function notes()
    {
        return $this->belongsToMany(Note::class);
    }

    // public function syncNote(array $tag_ids, Note $note)
    // {
    //     foreach ($tag_ids as $tag_id)
    //     {
    //         $note->tags()->sync($tag_id);
    //     }
    // }
}
