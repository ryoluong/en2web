<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Slack;
use Illuminate\Support\Facades\Log;
use App\Note;

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
            $note = Note::all()->first();
            $note_content = mb_substr($note->content, 0, 50);
            if($note->photos->count()) {
                $note_image = 'en2ynu.com' . $note->photos->first()->path;
            } else {
                $note_image = 'en2ynu.com/img/note_cover_photo/' . $note->category->id . '.jpg';
            }
            $note_title = $note->title;
            $note_link = "http://en2ynu.com/notes/" . $note->id;
            $content = json_encode([
                'replyToken' => $event['replyToken'],
                'messages' => [
                    [
                        "type" => "template",
                        "altText" => "New Note Posted!",
                        "template" => [
                            "type" => "buttons",
                            "thumbnailImageUrl" => $note_image,
                            "imageAspectRatio" => "rectangle",
                            "imageSize" => "cover",
                            "imageBackgroundColor" => "#FFFFFF",
                            "title" => $note_title,
                            "text" => $note_content,
                            "defaultAction" => [
                                "type" => "uri",
                                "label" => "See note",
                                "uri" => $note_link
                            ],
                            "actions" => [
                                "type" => "uri",
                                "label" => "View detail",
                                "uri" => $note_link
                            ]
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
