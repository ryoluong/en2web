<?php

namespace App\Http\Controllers;

use App\Note;
use App\User;
use App\Category;
use App\Country;
use App\Tag;
use App\Photo;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SearchFormRequest;
use App\Usecases\Note\SearchNoteUsecase;
use App\Facades\Line;
use App\Facades\Slack;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::where('isBest', true)->inRandomOrder()->take(6)->get();
        $flag = 'index';
        $categories = Category::all();
        $tags = Tag::all();
        return view('web.notes.index', compact(['notes', 'categories', 'tags', 'flag']));
    }

    public function showAll()
    {
        $notes = Note::orderBy('date', 'desc')->paginate(6);
        $flag = 'all';
        $title = 'All Notes';
        $count = Note::all()->count();
        return view('web.notes.paginate', compact(['notes', 'flag', 'title', 'count']));
    }

    public function showBest()
    {
        $notes = Note::where('isBest', true)->orderBy('date', 'desc')->paginate(6);
        $flag = 'isBest';
        $title = 'Best Notes';
        $count = Note::where('isBest', true)->count();
        return view('web.notes.paginate', compact(['notes', 'flag', 'title', 'count']));
    }

    public function showLike()
    {
        $notes_obj = auth()->user()->favNotes();
        $notes = $notes_obj->paginate(6);
        $flag = 'like';
        $title = 'Liked Notes';
        $count = auth()->user()->favNotes()->count();
        return view('web.notes.paginate', compact(['notes', 'flag', 'title', 'count']));
    }

    public function showByTag(Tag $tag)
    {
        $notes = $tag->notes()->orderBy('date', 'desc')->paginate(6);
        $flag = 'tag';
        $title = 'Notes【Tag: '.$tag->name.'】';
        $count = $tag->notes()->count();
        return view('web.notes.paginate', compact(['notes', 'tag', 'flag', 'title', 'count']));
    }

    public function showByCategory(Category $category)
    {
        $notes = Note::where('category_id', $category->id)->orderBy('date', 'desc')->paginate(6);
        $flag = 'category';
        $title = 'Notes【Category: '.$category->name.'】';
        $count = Note::where('category_id', $category->id)->count();
        return view('web.notes.paginate', compact(['notes', 'category', 'flag', 'title', 'count']));
    }

    public function showByAuthor(User $user)
    {
        $notes = $user->notes()->orderBy('date', 'desc')->paginate(6);
        $flag = 'author';
        $title = 'Notes【Author: '.$user->name.'】';
        $count = $user->notes()->count();
        return view('web.notes.paginate', compact(['notes', 'user', 'flag', 'title', 'count']));
    }

    public function showByCountry(Country $country)
    {
        $notes = $country->notes()->orderBy('date', 'desc')->paginate(6);
        $flag = 'country';
        $title = 'Notes【Country: '.$country->name.'】';
        $count = $country->notes()->count();
        return view('web.notes.paginate', compact(['notes', 'country', 'flag', 'title', 'count']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'author' => ['required', 'exists:users,name'],
            'country' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'tag_ids.*' => ['exists:tags,id'],
            'files.*.photo' => ['file', 'image', 'mimes:jpeg,png',],
            'content' => ['required'],
        ]);
    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $users = User::whereIn('status', [1,3])->get();
        return view('web.notes.create', compact(['categories', 'tags', 'users']));
    }

    public function confirm(Request $request)
    {
        $this->validator($request->all())->validate();
        $bridge_request = $request->all();
        $categories = Category::all();
        $tags = Tag::all();

        if ($request->file('files') !== null) {
            $paths = resizeAndSavePhotosToTempDir($request->file('files'), 800);
        } else {
            $paths = [];
        }
        return view('web.notes.create_confirm', compact(['categories', 'tags', 'paths']))->with($bridge_request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $action = request('action');
        $input = request()->except('action');

        if ($action === 'create') {
            $user_id = DB::table('users')->where('name', $request->author)->first()->id;

            $note = Note::create(
                request(['title', 'date', 'category_id', 'isBest', 'content']) + ['user_id' => $user_id]
            );

            //タグの処理
            $note->tags()->sync(request('tag_ids'));

            //国の処理
            if (request('country') !== null) {
                $country_ids = getCountryIdsFromRequest(request('country'));
                $note->countries()->sync($country_ids);
            }
            
            //画像の移動
            if ($request->paths !== null) {
                movePhotosFromTempDirToNoteDir($request->paths, $note);
            }

            if (request('line_notice')) {
                Line::note($note, 'New note posted!');
            }
            
            return redirect('/notes/'.$note->id);
        } else {
            if ($request->paths !== null) {
                Storage::disk('public')->delete($request->paths);
            }
            return redirect()->action('NotesController@create')->withInput($input);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        $escapedString = nl2br(htmlspecialchars($note->content, ENT_QUOTES, 'UTF-8'));
        $pattern = '/(http|https):\/\/([A-Z0-9][A-Z0-9_-]*(?:[\.\/][\?%#A-Z0-9][\?&%;=#A-Z0-9_-]*)+):?(\d+)?\/?/i';
        $replacement = '<a class="escaped_link" href="$0" target="_blank">$0</a>';
        $note->content = preg_replace($pattern, $replacement, $escapedString);
        return view('web.notes.show', compact(['note']));
    }

    public function share(Note $note)
    {
        $message = auth()->user()->name. ' shared a note.';
        Line::note($note, $message);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        $country_name = '';
        foreach ($note->countries as $country) {
            $country_name .= $country->name.' ';
        }
        $note_tags = [];
        foreach ($note->tags as $tag) {
            $note_tags[] = $tag->id;
        }
        $categories = Category::all();
        $tags = Tag::all();
        return view('web.notes.edit', compact(['note','categories', 'tags', 'country_name', 'note_tags']));
    }

    public function editConfirm(Request $request, Note $note)
    {
        $this->validator($request->all())->validate();
        $bridge_request = $request->all();
        $categories = Category::all();
        $tags = Tag::all();

        $paths = [];
        if ($request->file('files') !== null) {
            foreach ($request->file('files') as $index => $e) {
                $filename = uniqid('photo_').'.'.$e['photo']->guessExtension();
                $path = \Image::make(file_get_contents($e['photo']->getRealPath()));
                $path
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path().'/storage/img/tmp/'.$filename);
                $paths[] = '/img/tmp/'.$filename;
            }
        }
        return view('web.notes.edit_confirm', compact(['note', 'categories', 'tags', 'paths']))->with($bridge_request);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $action = request('action');
        $input = $request->except('action');
        if ($action == 'update') {
            $user_id = DB::table('users')->where('name', $request->author)->first()->id;

            $note->title = $request->title;
            $note->date = $request->date;
            $note->user_id = $user_id;
            $note->category_id = $request->category_id;
            $note->isBest = $request->isBest;
            $note->content = $request->content;

            $note->save();

            //タグの処理
            if ($request->tag_ids !== null) {
                $tag_ids[] = $request->tag_ids;
                foreach ($tag_ids as $tag_id) {
                    $note->tags()->sync($tag_id);
                }
            } else {
                $array = [];
                $note->tags()->sync($array);
            }
            
            //国の処理
            $temp = mb_convert_kana($request->country, 's');
            $country_names = preg_split('/[\s,]+/', $temp, -1, PREG_SPLIT_NO_EMPTY);
            $country_ids = [];
            foreach ($country_names as $country_name) {
                $country = Country::firstOrCreate([
                    'name' => $country_name,
                ]);
                $country_ids[] = $country->id;
            }
            $note->countries()->sync($country_ids);

            //画像の処理
            if ($request->paths !== null) {
                $current_index = $note->photos->count();
                foreach ($request->paths as $index => $path) {
                    $newindex = $index + $current_index;
                    $filename = 'photo_'.$note->id.'_'.$newindex.'_'.uniqid().'.'.pathinfo($path, PATHINFO_EXTENSION);
                    Storage::disk('public')->move($path, '/storage/img/note/'.$filename);
                    $note->photos()->create(['path' => '/storage/img/note/'.$filename]);
                }
            }
            if ($request->delete_paths !== null) {
                foreach ($request->delete_paths as $path) {
                    Photo::where('path', $path)->first()->delete();
                    unlink(public_path().$path);
                }
            }
            return redirect('/notes/'.$note->id);
        } else {
            if (isset($request->paths)) {
                Storage::disk('public')->delete($request->paths);
            }
            return redirect()->action('NotesController@edit', $note)->withInput($input);
        }
    }

    public function deleteConfirm(Note $note)
    {
        $note_id = $note->id;
        $notes = [];
        $notes[] = $note;
        return view('web.notes.delete_confirm', compact(['notes', 'note_id']));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        foreach ($note->photos as $photo) {
            unlink(public_path().$photo->path);
        }
        $note->delete();
        return redirect('/notes');
    }

    public function showSearchForm()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('web.notes.search', compact(['categories', 'tags']));
    }

    public function search(SearchFormRequest $request, SearchNoteUsecase $usecase)
    {
        $flag = 'search';
        $notes_tmp = $usecase(
            $request->keywords,
            $request->category_id,
            $request->tag_ids,
            $request->author,
            $request->country,
            $request->isBest,
            $request->from_year,
            $request->from_month,
            $request->to_year,
            $request->to_month
        );
        $count = $notes_tmp->count();
        $title = 'Search Notes';
        $notes = $notes_tmp->orderBy('date', 'desc')->paginate(6);
        return view('web.notes.paginate', compact(['notes', 'count', 'title', 'flag']));
    }

    public function fav()
    {
        $user = auth()->user();
        $note_id = request()->note_id;
        $user->favNotes()->toggle([$note_id]);
    }
}
