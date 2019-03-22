<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Slack;

class LineApiController extends Controller
{
    protected $url = 'https://api.line.me/v2/bot/message/push';
    protected $channelToken = 'sv/RKt1C3qskQg0Uh5Xdll9aXWvy42rty+y9gdYtQjzQ5AOMMKOgPPU6yTAuxkoRsTXsWVSmv648F5wXHJzpvWPCkUSnfdjuxj91YZIr7Np4rGPlgFFbsAFeyuL6I8nUFSYZCQvvEZkfHngYPfAtUgdB04t89/1O/w1cDnyilFU=';


    public function __construct()
    {
        
    }

    public function response()
    {
        http_response_code();
        echo '200 {}';
        $json_string = request()->getContent();
        $json_object = json_decode($json_string, true);
        $event = $json_object['events'][0];
        if($event['type'] == 'join') {
            Slack::notice('Bot joined group! groupID: '.$event['source']['groupId']);
        }
    }
}
