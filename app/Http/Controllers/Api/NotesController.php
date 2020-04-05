<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Note;
use App\User;
use App\Country;
use App\Category;
use App\Tag;
use App\Photo;
use App\Facades\Slack;

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
            ->orderBy('id', 'desc')
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

    public function get($noteId)
    {
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
        if (!request('for_edit', false)) {
            $escapedString = nl2br(htmlspecialchars($note->content, ENT_QUOTES, 'UTF-8'));
            $escapedString = str_replace('&amp;nbsp;', ' ', $escapedString);
            $pattern = '/(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:[\.\/][\?%#A-Z0-9][\?&%;=#A-Z0-9_-]*)+):?(\d+)?\/?/i';
            $replacement = '<a class="escaped_link" href="$0" target="_blank">$0</a>';
            $note->content = preg_replace($pattern, $replacement, $escapedString);
        }
        return $note;
    }

    public function store()
    {
        $note = Note::create(
            request(['title', 'user_id', 'date', 'category_id', 'isBest', 'content'])
        );

        $countryIds = [];
        foreach (request('countries', []) as $countryName) {
            $country = Country::firstOrCreate([
                'name' => $countryName
            ]);
            $countryIds[] = $country->id;
        }
        $note->countries()->sync($countryIds);

        $tagIds = [];
        foreach (request('tags', []) as $tagName) {
            $tag = Tag::firstOrCreate([
                'name' => $tagName
            ]);
            $tagIds[] = $tag->id;
        }
        $note->tags()->sync($tagIds);

        if (request()->file('files') !== null) {
            foreach (request()->file('files') as $i => $file) {
                $photo = \Image::make($file)->orientate();
                $photo = $this->resize($photo);
                $uniqid = uniqid();
                $ext = $file->guessExtension();
                $filename = "photo_{$note->id}_{$i}_{$uniqid}.{$ext}";
                $path = public_path('storage/img/note/') . $filename;
                $photo->save($path);
                $note->photos()->create(['path' => '/storage/img/note/'.$filename]);
            }
        }

        if (request('should_post_slack') && $note->user_id == auth()->user()->id) {
            Slack::postNote($note);
        }

        return $note;
    }

    public function update(Note $note)
    {
        $note->update(request(['title', 'user_id', 'date', 'category_id', 'isBest', 'content']));
        $countryIds = [];
        foreach (request('countries', []) as $countryName) {
            $country = Country::firstOrCreate([
                'name' => $countryName
            ]);
            $countryIds[] = $country->id;
        }
        $note->countries()->sync($countryIds);
        $tagIds = [];
        foreach (request('tags', []) as $tagName) {
            $tag = Tag::firstOrCreate([
                'name' => $tagName
            ]);
            $tagIds[] = $tag->id;
        }
        $note->tags()->sync($tagIds);

        if (request()->file('files') !== null) {
            foreach (request()->file('files') as $i => $file) {
                $photo = \Image::make($file)->orientate();
                $photo = $this->resize($photo);
                $uniqid = uniqid();
                $ext = $file->guessExtension();
                $filename = "photo_{$note->id}_{$i}_{$uniqid}.{$ext}";
                $path = public_path('storage/img/note/') . $filename;
                $photo->save($path);
                $note->photos()->create(['path' => '/storage/img/note/'.$filename]);
            }
        }

        foreach (request('delete_photo_ids', []) as $photoId) {
            Photo::find($photoId)->delete();
        }

        return $this->get($note->id);
    }

    public function destroy(Note $note)
    {
        foreach ($note->photos as $photo) {
            unlink(public_path($photo->path));
        }
        return response()->json(["ok" => $note->delete()]);
    }

    private function resize($photo)
    {
        $w = $photo->width();
        $h = $photo->height();
        if ($h > 800 && $h > $w) {
            $photo->resize(null, 800, function($constraint) { $constraint->aspectRatio(); });
        } elseif ($w > 800 && $w > $h) {
            $photo->resize(800, null, function($constraint) { $constraint->aspectRatio(); });
        }
        return $photo;
    }

    public function categories()
    {
        return Category::select('id', 'name')->get();
    }

    public function tags()
    {
        return Tag::select('id', 'name')->get();
    }
}
