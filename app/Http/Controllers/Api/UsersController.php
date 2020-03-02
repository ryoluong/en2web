<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

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
    public function get($id) {
        $user = User::select('id', 'name', 'avater_path', 'coverimg_path', 'generation', 'group_id', 'isOB', 'isHennyu', 'department', 'major', 'profile', 'year', 'job')
            ->with('countries:countries.id,countries.name,english_name')
            ->where('id', $id)
            ->first();
        $user->profile = $user->getEscapedProfile();
        return $user;
    }
}
