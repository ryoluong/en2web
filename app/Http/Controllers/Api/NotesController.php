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
        $category_id = request('category_id');
        return Note::select('id', 'user_id', 'category_id', 'title', 'isBest', 'date')
            ->with([
                'user:id,name,avater_path',
                'category:id,name',
                'countries:countries.id,name,english_name',
                'tags:tags.id,name',
                'photos:id,note_id,path'
            ])
            ->when($category_id, function ($q) use ($category_id) {
                return $q->where('notes.category_id', $category_id);
            })
            ->withCount(['favUsers'])
            ->orderBy('date', 'desc')
            ->paginate(10);
    }

    public function fav($noteId) {
        return auth()->user()->favNotes()->toggle([$noteId]);
    }

    public function get($noteId) {
        $note = Note::where('id', $noteId)
            ->select('id', 'user_id', 'category_id', 'title', 'isBest', 'date', 'content')
            ->with([
                'user:id,name,avater_path',
                'category:id,name',
                'countries:countries.id,name,english_name',
                'tags:tags.id,name',
                'photos:id,note_id,path'
            ])
            ->withCount(['favUsers'])
            ->firstOrFail();
        $escapedString = nl2br(htmlspecialchars($note->content, ENT_QUOTES, 'UTF-8'));
        $pattern = '/(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:[\.\/][\?%#A-Z0-9][\?&%;=#A-Z0-9_-]*)+):?(\d+)?\/?/i';
        $replacement = '<a class="escaped_link" href="$0" target="_blank">$0</a>';
        $note->content = preg_replace($pattern, $replacement, $escapedString);
        return $note;
    }
}
