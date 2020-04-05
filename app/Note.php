<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'id' => 0,
            'name' => '退会したユーザー',
        ]);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function countries()
    {
        return $this->belongsToMany(Country::class);
    }
    
    public function tags()
    {
        return $this->belongsToMany(Tag::Class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function favUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
