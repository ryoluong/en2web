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
        return User::select('name', 'avater_path', 'generation', 'group_id', 'isOB', 'department_id')
            ->whereIn('status', ['1,3'])
            ->get();
    }
}
