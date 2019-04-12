<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Slack;
use Illuminate\Support\Facades\Log;
use App\Note;

class LineApiController extends Controller
{

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
        } 
        // elseif ($event['type'] == 'message') {
        //     $url = 'https://api.line.me/v2/bot/message/reply';
        //     $channelToken = config('const.LINE_CHANNEL_TOKEN');
        //     $headers = [
        //         'Authorization: Bearer ' . $channelToken,
        //         'Content-Type: application/json; charset=utf-8',
        //     ];
        //     $note = Note::where('id', '12')->first();
        //     $str = mb_substr($note->content, 0, 75).'......';
        //     $note_content = preg_replace('/[\n\r\t]/', ' ', $str);
        //     if($note->photos->count()) {
        //         $note_image = 'https://en2ynu.com' . $note->photos->first()->path;
        //     } else {
        //         $note_image = 'https://en2ynu.com/img/note_cover_photo/' . $note->category_id . '.jpg';
        //     }
        //     $note_title = $note->title;
        //     $note_author = $note->user->name;
        //     $note_link = "http://en2ynu.com/notes/" . $note->id;
        //     $content = json_encode([
        //         'replyToken' => $event['replyToken'],
        //         'messages' => [
        //             // [
        //             //     "type" => "text",
        //             //     "text" => '新しいノートが投稿されました！'
        //             // ],
        //             [
        //                 "type" => "flex",
        //                 "altText" => "New note posted!",
        //                 "contents" => [
        //                     "type" => "bubble",
        //                     "header" => [
        //                         "type" => "box",
        //                         "layout" => "baseline",
        //                         "contents" => [
        //                             [
        //                                 "type" => "text",
        //                                 "text" => "New Note Posted!",
        //                                 "weight" => "bold",
        //                                 "color" => "#777799",
        //                                 "size" => "md"
        //                             ]
        //                         ]
        //                     ],
        //                     "hero" => [
        //                         "type" => "image",
        //                         "margin" => "none",
        //                         "url" => $note_image,
        //                         "size" => "full",
        //                         "aspectRatio" => "2000:1000",
        //                         "aspectMode" => "cover",
        //                         "action" => [
        //                             "type" => "uri",
        //                             "uri" => $note_link
        //                         ]
        //                     ],
        //                     "body" => [
        //                         "type" => "box",
        //                         "layout" => "vertical",
        //                         "spacing" => "md",
        //                         "contents" => [
        //                             [
        //                                 "type" => "text",
        //                                 "text" => $note_title,
        //                                 "size" => "md",
        //                                 "weight" => "bold",
        //                                 "wrap" => true,
        //                                 "color" => "#555555",
        //                             ],
        //                             [
        //                                 "type" => "text",
        //                                 "text" => $note_author,
        //                                 "size" => "sm",
        //                                 "weight" => "bold",
        //                                 "wrap" => true,
        //                                 "color" => "#555555",
        //                             ],
        //                             [
        //                                 "type" => "text",
        //                                 "text" => $note_content,
        //                                 "size" => "xs",
        //                                 "wrap" => true,
        //                                 "color" => "#555555"
        //                             ]
        //                         ]
        //                     ],
        //                     "footer" => [
        //                         "type" => "box",
        //                         "layout" => "horizontal",
        //                         "contents" => [
        //                             [
        //                                 "type" => "button",
        //                                 "action" => [
        //                                     "type" => "uri",
        //                                     "label" => "See more",
        //                                     "uri" => $note_link
        //                                 ],
        //                                 "height" => "sm",
        //                                 "color" => "#777799",
        //                             ]
        //                         ]
        //                     ],
        //                     "styles" => [
        //                         "footer" => [
        //                         "separator" => true
        //                         ]
        //                     ]
        //                 ]
        //             ],
        //         ],
        //     ]);
        //     $options = array (
        //         'http' => array (
        //             'method' => 'POST',
        //             'header' => $headers,
        //             'content' => $content,
        //             'ignore_errors' => true,
        //             'protocol_version' => '1.1'
        //             ),
        //         'ssl' => array (
        //             'verify_peer' => false,
        //             'verify_peer_name' => false
        //             )
        //         );
        //     $response = file_get_contents($url, false, stream_context_create($options));
        //     Log::info($response);
        //     return $response;
        // }
    }
}
