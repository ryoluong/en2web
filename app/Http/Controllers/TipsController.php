<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TipsController extends Controller
{
    public function internationalSpace()
    {
        return view('web.tips.international_space');
    }
}
