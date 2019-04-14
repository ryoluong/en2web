<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $guarded = [
        'id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function meeting() {
        return $this->belongsTo(Meeting::class);
    }
}
