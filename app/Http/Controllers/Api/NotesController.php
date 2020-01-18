<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Note;

class NotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        return Note::select('id', 'user_id', 'category_id', 'title', 'is_best', 'date')
            ->with([
                'user:id,name,avater_path',
                'category:id,name',
                'countries:countries.id,name,english_name',
                'tags:tags.id,name',
                'photos:id,note_id,path'
            ])
            ->orderBy('date', 'desc')
            ->paginate(10);
    }
}
