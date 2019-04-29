<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UrlSchemeController extends Controller
{
    public function twitter($id)
    {
        return view('web.user.twitter', compact('id'));
    }

    public function instagram($id)
    {
        return view('web.user.instagram', compact('id'));
    }
}
