<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Note;
use App\User;
use Illuminate\Support\Facades\Log;

class NotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $user_id = request('user_id');
        $category_id = request('category_id');
        $is_best = request('is_best');
        $limit = request('limit', 10);
        $notes = Note::select('id', 'user_id', 'category_id', 'title', 'isBest', 'date')
            ->with([
                'user:id,name,avater_path',
                'category:id,name',
                'countries:countries.id,name,english_name',
                'tags:tags.id,name',
                'photos:id,note_id,path'
            ])
            ->when($user_id, function($q) use ($user_id) {
                return $q->where('notes.user_id', $user_id);
            })
            ->when($category_id, function ($q) use ($category_id) {
                return $q->where('notes.category_id', $category_id);
            })
            ->when($is_best, function($q) {
                return $q->where('isBest', true);
            })
            ->withCount(['favUsers'])
            ->orderBy('date', 'desc')
            ->paginate($limit);
        $conditions = [];
        if ($user_id) {
            $conditions[] = [
                "icon"  => "mdi-account-edit",
                "data" => User::select('id','name')->where('id', $user_id)->first()
            ];
        }
        return collect(compact('conditions'))->merge($notes);
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
