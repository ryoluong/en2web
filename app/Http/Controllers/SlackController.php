<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SlackController extends Controller
{

    const URL_VERIFICATION = "url_verification";

    public function response()
    {
        switch(request('type')) {
            case self::URL_VERIFICATION:
                return response()->json(
                    ['challenge' =>request('challenge')]
                );
            default:
                return 'piyopiyo';
        }
    }
}
