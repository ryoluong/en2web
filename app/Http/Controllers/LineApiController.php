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
                        "type" => "text",
                        "text" => "hihi",
                    ],
                    [
                        "type" => "template",
                        "altText" => "This is a buttons template",
                        "template" => [
                            "type" => "buttons",
                            "thumbnailImageUrl" => "https://example.com/bot/images/image.jpg",
                            "imageAspectRatio" => "rectangle",
                            "imageSize" => "cover",
                            "imageBackgroundColor" => "#FFFFFF",
                            "title" => "Menu",
                            "text" => "Please select",
                            "defaultAction" => [
                                "type" => "uri",
                                "label" => "View detail",
                                "uri" => "http://example.com/page/123"
                            ],
                            "actions" => [
                                [
                                    "type" => "postback",
                                    "label" => "Buy",
                                    "data" => "action=buy&itemid=123"
                                ],
                                [
                                    "type" => "postback",
                                    "label" => "Add to cart",
                                    "data" => "action=add&itemid=123"
                                ],
                                [
                                    "type" => "uri",
                                    "label" => "View detail",
                                    "uri" => "http://example.com/page/123"
                                ]
                            ],
                        ],
                    ],
                ],
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
            Log::info($response);
            return $response;
        }
    }
}
