<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlackController extends Controller
{

    const URL_VERIFICATION = "url_verification";

    public function command()
    {
        if($this->verifyToken(request('token'))) {
            return response()->json(
                [
                    "text" => "Thanks for your request, we'll process it and get back to you."
                ]
            );
        } else {
            return response()->json(
                ['error' => 'token invalid'], 
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    public function response()
    {
        if ($this->verifyToken(request('token'))) {
            switch(request('type')) {
                case self::URL_VERIFICATION:
                    return response()->json(
                        ['challenge' =>request('challenge')]
                    );
                default:
                    return 'piyopiyo';
            }
        } else {
            return response()->json(
                ['error' => 'token invalid'], 
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    private function verifyToken($incomingToken)
    {
        return $incomingToken && $incomingToken === config('const.SLACK_VERIFICATION_TOKEN');
    }
}
