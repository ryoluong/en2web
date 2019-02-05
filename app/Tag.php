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
}
