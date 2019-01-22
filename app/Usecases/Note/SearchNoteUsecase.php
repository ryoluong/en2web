<?php

namespace App\Usecases\Note;

use App\Note;
use App\Tag;
use App\User;
use DB;

class SearchNoteUsecase
{
    public function __invoke($category_id = null, $tag_ids = null, $author = null, $isBest = null)
    {
        $notes = new Note();

        $result = $notes->when(!is_null($category_id), function ($query) use ($category_id) {
            return $query->where('notes.category_id', $category_id);
        })->when(!is_null($tag_ids), function ($query) use ($tag_ids) {
            $array = [];
            foreach($tag_ids as $index => $tag_id) {
                $note_ids = DB::table('note_tag')->select('note_id')->where('tag_id', $tag_id)->get();
                if($index == 0) {
                    foreach($note_ids as $note_id) {
                        $array[] = $note_id->note_id;
                    }
                } else {
                    $tmp = [];
                    foreach($note_ids as $note_id) {
                        $tmp[] = $note_id->note_id;
                    }
                    $array = array_intersect($array, $tmp);
                }
            }
            return $query->whereIn('notes.id', $array);
        })->when(!is_null($author), function ($query) use ($author) {
            $array = [];
            $user_ids = DB::table('users')->select('id')->where('name', 'LIKE', "$author")->orWhere('name', 'LIKE', "$author %")->orWhere('name', 'LIKE', "% $author")->get();
            foreach($user_ids as $user_id) {
                $array[] = $user_id->id;
            }
            return $query->whereIn('notes.user_id', $array);
        })->when(!is_null($isBest), function ($query) use ($isBest) {
            return $query->where('notes.isBest', true);
        });

        return $result;
    }
}