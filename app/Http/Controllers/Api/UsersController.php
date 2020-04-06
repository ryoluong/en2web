<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Country;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    
    public function index()
    {
        return User::select('id', 'name', 'avater_path', 'generation', 'group_id', 'isOB', 'department_id')
            ->whereIn('status', [1,3])
            ->get();
    }
    public function get($id)
    {
        $user = User::select(
            'id', 
            'name', 
            'avater_path', 
            'coverimg_path', 
            'generation',
            'group_id',
            'isOB',
            'isOverseas',
            'isHennyu',
            'department',
            'major',
            'profile',
            'year',
            'job',
            'twitter_id',
            'instagram_id',
            'university'
        )
            ->with('countries:countries.id,countries.name,english_name')
            ->with(['notes' => function($q) {
                $q
                ->select('id', 'user_id', 'category_id', 'title', 'isBest', 'date')
                ->with([
                    'user:id,name,avater_path',
                    'category:id,name',
                    'countries:countries.id,name,english_name',
                    'tags:tags.id,name',
                    'photos:id,note_id,path'
                ])
                ->withCount(['favUsers'])
                ->limit(4)
                ->orderBy('date', 'desc');
            }])
            ->withCount(['notes'])
            ->where('id', $id)
            ->first();
        if (!$user) {
            abort(404, 'not found');
        }
        $user->escaped_profile = $user->getEscapedProfile();
        return $user;
    }
    public function update()
    {
        $user = auth()->user();
        $user->update(
            request(['twitter_id', 'instagram_id', 'university', 'job', 'isOverseas', 'isOB', 'profile'])
        );

        $countryIds = [];
        foreach (request('countries', []) as $countryName) {
            $country = Country::firstOrCreate([
                'name' => $countryName
            ]);
            $countryIds[] = $country->id;
        }
        $user->countries()->sync($countryIds);

        return response()->json($user);
    }
}
