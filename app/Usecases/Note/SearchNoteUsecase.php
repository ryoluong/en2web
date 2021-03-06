<?php

namespace App\Usecases\Note;

use App\Note;
use App\Tag;
use App\User;
use App\Country;
use DB;

class SearchNoteUsecase
{
    public function __invoke($keywords = null, $category_id = null, $tag_ids = null, $author = null, $country = null, $isBest = null, $from_year, $from_month, $to_year, $to_month)
    {
        $notes = new Note();

        $result = $notes->when(!is_null($keywords), function ($query) use ($keywords) {
            $temp = mb_convert_kana($keywords, 'as');
            $keywords_array = preg_split('/[\s,]+/', $temp, -1, PREG_SPLIT_NO_EMPTY);
            foreach($keywords_array as $key) {
                $query
                ->where(function($query) use ($key) {
                    if(Country::where('name', $key)->exists()) {
                        $country_id = Country::where('name', $key)->first()->id;
                        $note_ids = DB::table('country_note')->select('note_id')->where('country_id', $country_id)->get();
                        $array = [];
                        foreach($note_ids as $note_id) {
                            $array[] = $note_id->note_id;
                        }     
                        $query->whereIn('notes.id', $array);
                    }
                    if(User::where('name', 'LIKE', "$key %")->orWhere('name', 'LIKE', "% $key")->exists()) {
                        $array = [];
                        $user_ids = DB::table('users')->select('id')->where('name', 'LIKE', "$key %")->orWhere('name', 'LIKE', "% $key")->get();
                        foreach($user_ids as $user_id) {
                            $array[] = $user_id->id;
                        }
                        $query->whereIn('notes.user_id', $array);
                    }
                    $query
                    ->orWhere('notes.content', 'LIKE', "%$key%")
                    ->orWhere('notes.title', 'LIKE', "%$key%");
                    return $query;
                });
            }
            return $query;
        })->when(!is_null($category_id), function ($query) use ($category_id) {
            return $query->where('notes.category_id', $category_id);
        })->when(!is_null($tag_ids), function ($query) use ($tag_ids) {
            $note_ids = DB::table('note_tag')
                ->select(DB::raw('note_id, count(note_id) as count'))
                ->whereIn('tag_id', $tag_ids)
                ->groupBy('note_id')
                ->having('count', count($tag_ids))
                ->pluck('note_id');
            return $query->whereIn('notes.id', $note_ids);
        })->when(!is_null($author), function ($query) use ($author) {
            $array = [];
            $user_ids = DB::table('users')->select('id')->where('name', 'LIKE', "$author")->orWhere('name', 'LIKE', "$author %")->orWhere('name', 'LIKE', "% $author")->get();
            foreach($user_ids as $user_id) {
                $array[] = $user_id->id;
            }
            return $query->whereIn('notes.user_id', $array);
        })->when(!is_null($country), function ($query) use ($country) {
            if(Country::where('name', $country)->exists()) {
                $country_id = Country::where('name', $country)->first()->id;
                $note_ids = DB::table('country_note')->select('note_id')->where('country_id', $country_id)->get();
                $array = [];
                foreach($note_ids as $note_id) {
                    $array[] = $note_id->note_id;
                }     
                $query->whereIn('notes.id', $array);
            }
            return $query;
        })->when(!empty($from_year), function($query) use ($from_year) {
            return $query->whereYear('notes.date', '>=', $from_year);
        })->when(!empty($from_month), function($query) use ($from_month) {
            return $query->whereMonth('notes.date', '>=', $from_month);
        })->when(!empty($to_year), function($query) use ($to_year) {
            return $query->whereYear('notes.date', '<=', $to_year);
        })->when(!empty($to_month), function($query) use ($to_month) {
            return $query->whereMonth('notes.date', '<=', $to_month);
        })->when(!is_null($isBest), function ($query) use ($isBest) {
            return $query->where('notes.isBest', true);
        });

        return $result;
    }
}