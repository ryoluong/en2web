<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Rules\GenerationVali;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use App\Country;
use App\Tag;
use App\Category;

class UserController extends Controller
{
    public function showHome () {
        $user = auth()->user();
        if(isset($user->countries()->first()->name)) {
            $user_country = $user->countries()->first()->name;
        } else {
            $user_country = "noCountry";
        }
        
        return view('web.home', compact(['user', 'user_country']));
    }

    public function showMyPage() {
        $countries = Country::all();
        $user = auth()->user();
        $notes = auth()->user()->notes->take(3);
        return view('web.mypage', compact(['user', 'countries', 'notes']));
    }

    public function editMyPage() {
        $max = User::max('generation');
        $user = auth()->user();
        return view('web.mypage_edit', compact(['user','max']));
    }

    public function updateMyPage() {
        $user = auth()->user();
        request()->validate([
            'year' => ['nullable', 'digits:4'],
            'department' => ['required', Rule::in(['経済学部','経営学部','教育学部','都市科学部','理工学部'])],
            'major' => ['required', Rule::in(['経済学科','経営学科','教育学科','都市社会共生学科','環境リスク共生学科','建築学科','都市基盤学科','数物・電子情報系学科','化学・生命系学科','機械・材料・海洋系学科'])],
            'generation' => ['required', new GenerationVali],
            'countries' => ['nullable', 'string', 'max:255'],
            'university' => ['nullable', 'string', 'max:255'],
            'isOB' => ['nullable', 'in:1'],
            'job' => ['nullable', 'string', 'max:255'],
            'profile' => ['nullable', 'max:2000'],
        ]);

        if ((request('isOB')) === null) { $isOB = 0; } else { $isOB = 1; }
        $user->year = request('year');
        $user->department = request('department');
        $user->major = request('major');
        $user->generation = request('generation');

        $uni_temp = mb_convert_kana(request()->university, 's');
        $unis = preg_split('/[\s,]+/', $uni_temp, -1, PREG_SPLIT_NO_EMPTY);
        $university = '';
        foreach($unis as $u)
        {
            $university .= $u.' ';
        }
        $user->university = $university;

        $user->isOB = $isOB;
        $user->job = request('job');
        $user->profile = request('profile');
        $user->save();

        $temp = mb_convert_kana(request('countries'), 's');
        $country_names = preg_split('/[\s,]+/', $temp, -1, PREG_SPLIT_NO_EMPTY);
        $country_ids = [];
        foreach ($country_names as $country_name) {
            $country = Country::firstOrCreate([
                'name' => $country_name,
            ]);
            $country_ids[] = $country->id;
        }
        $user->countries()->sync($country_ids);
        
        return redirect('/mypage');
    }
}
