<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Slack;
use Illuminate\Support\Facades\Log;

class LineApiController extends Controller
{
    protected $url = 'https://api.line.me/v2/bot/message/push';
    protected $channelToken = 'sv/RKt1C3qskQg0Uh5Xdll9aXWvy42rty+y9gdYtQjzQ5AOMMKOgPPU6yTAuxkoRsTXsWVSmv648F5wXHJzpvWPCkUSnfdjuxj91YZIr7Np4rGPlgFFbsAFeyuL6I8nUFSYZCQvvEZkfHngYPfAtUgdB04t89/1O/w1cDnyilFU=';

    public function response()
    {
        http_response_code();
        echo '200 {}';
        $json_string = request()->getContent();
        $json_object = json_decode($json_string, true);
        $event = $json_object['events'][0];
        if($event['type'] == 'join') {
            $message = 'LINE Bot joined group! groupID: `'.$event['source']['groupId'].'`';
            Log::info($message);
            Slack::notice($message);
        } elseif ($event['type'] == 'message') {
            $url = 'https://api.line.me/v2/bot/message/reply';
            $channelToken = 'sv/RKt1C3qskQg0Uh5Xdll9aXWvy42rty+y9gdYtQjzQ5AOMMKOgPPU6yTAuxkoRsTXsWVSmv648F5wXHJzpvWPCkUSnfdjuxj91YZIr7Np4rGPlgFFbsAFeyuL6I8nUFSYZCQvvEZkfHngYPfAtUgdB04t89/1O/w1cDnyilFU=';
            $headers = [
                'Authorization: Bearer ' . $channelToken,
                'Content-Type: application/json; charset=utf-8',
            ];
            $content = json_encode([
                'replyToken' => $event['replyToken'],
                'messages' => [
                    [
                        'type' => 'flex', 
                        'altText' => 'this is a flex message',
                        'contents' => [
                            'type' => 'bubble',
                            'body' => [
                                'type' => 'box',
                                'layout' => 'vertical',
                                'contents' => [
                                    'type' => 'text',
                                    'text' => 'hello',
                                ],
                                [
                                    'type' => 'text',
                                    'text' => 'world',
                                ],
                            ],
                        ],
                    ],
                ]
            ]);
            $options = array (
                'http' => array (
                    'method' => 'POST',
                    'header' => $headers,
                    'content' => $content,
                    'ignore_errors' => true,
                    'protocol_version' => '1.1'
                    ),
                'ssl' => array (
                    'verify_peer' => false,
                    'verify_peer_name' => false
                    )
                );
            $response = file_get_contents($url, false, stream_context_create($options));
            return $response;
        }
    }
}
