<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineApiController extends Controller
{
    protected $bot;

    public function __construct()
    {
        $httpClient = new \LINE\LineBot\HTTPClient\CurlHttpClient('sv/RKt1C3qskQg0Uh5Xdll9aXWvy42rty+y9gdYtQjzQ5AOMMKOgPPU6yTAuxkoRsTXsWVSmv648F5wXHJzpvWPCkUSnfdjuxj91YZIr7Np4rGPlgFFbsAFeyuL6I8nUFSYZCQvvEZkfHngYPfAtUgdB04t89/1O/w1cDnyilFU=');
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '7a7c6907e671492c584c734f071a3005']);
    }

    public function response()
    {
        http_response_code();
        echo '200 {}';
        $json_string = request()->getContent();
        $json_object = json_decode($json_string, true);
        $event = $json_object['events'][0];
        $response = $bot->replyText($event->replyToken, 'hello!');
    }
}
