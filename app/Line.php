<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Note;
use App\Event;

class Line extends Model
{

    public function notice(string $str)
    {
        $url = 'https://api.line.me/v2/bot/message/push';
        $channelToken = config('const.LINE_CHANNEL_TOKEN');
        $headers = [
            'Authorization: Bearer ' . $channelToken,
            'Content-Type: application/json; charset=utf-8',
        ];
        $content = json_encode([
            'to' => config('const.LINE_EN2_KYOYU_GROUP_ID'),
            'messages' => [
                [
                    'type' => 'text', 
                    'text' => $str,
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

    public function remindEvent(Event $event)
    {
        $url = 'https://api.line.me/v2/bot/message/push';
        $channelToken = config('const.LINE_CHANNEL_TOKEN');
        $headers = [
            'Authorization: Bearer ' . $channelToken,
            'Content-Type: application/json; charset=utf-8',
        ];
        $event_title = $event->title;
        $event_date = $event->date;
        $event_time = preg_replace('/:[0-9]+$/', '', $event->start_time) .'~'. preg_replace('/:[0-9]+$/', '', $event->end_time);
        $event_location = $event->location;
        $content = json_encode([
            'to' => config('const.LINE_EN2_KYOYU_GROUP_ID'),
            'messages' => [
                [
                    "type" => "flex",
                    "altText" => 'リマインド',
                    "contents" => [
                        "type" => "bubble",
                        "body" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => [
                                [
                                    "type" => "text",
                                    "text" => $event_title,
                                    "size" => "md",
                                    "weight" => "bold",
                                    "wrap" => true,
                                    "color" => "#555555",
                                ],
                                [
                                    "type" => "text",
                                    "text" => $event_date,
                                    "size" => "sm",
                                    "weight" => "bold",
                                    "wrap" => true,
                                    "color" => "#555555",
                                ],
                                [
                                    "type" => "text",
                                    "text" => $event_time,
                                    "size" => "sm",
                                    "wrap" => true,
                                    "color" => "#555555",
                                ],                                
                                [
                                    "type" => "text",
                                    "text" => $event_location,
                                    "size" => "xs",
                                    "wrap" => true,
                                    "color" => "#555555",
                                ]
                            ]
                        ],
                    ]
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
    }

    public function note(Note $note, $header_text = 'Notification') 
    {
        $url = 'https://api.line.me/v2/bot/message/push';
        $channelToken = config('const.LINE_CHANNEL_TOKEN');
        $headers = [
            'Authorization: Bearer ' . $channelToken,
            'Content-Type: application/json; charset=utf-8',
        ];
        $tmp = mb_substr($note->content, 0, 50).'......';
        $note_content = preg_replace('/[\n\r\t]/', ' ', $tmp);
        if($note->photos->count()) {
            $note_image = 'https://en2ynu.com' . $note->photos->first()->path;
        } else {
            $note_image = 'https://en2ynu.com/img/note_cover_photo/' . $note->category_id . '.jpg';
        }
        $note_title = $note->title;
        $note_author = $note->user->name;
        $note_link = "https://en2ynu.com/notes/" . $note->id . '?openExternalBrowser=1';
        $content = json_encode([
            'to' => config('const.LINE_EN2_KYOYU_GROUP_ID'),
            'messages' => [
                [
                    "type" => "flex",
                    "altText" => $header_text,
                    "contents" => [
                        "type" => "bubble",
                        "header" => [
                            "type" => "box",
                            "layout" => "baseline",
                            "contents" => [
                                [
                                    "type" => "text",
                                    "text" => $header_text,
                                    "weight" => "bold",
                                    "color" => "#555577",
                                    "size" => "sm"
                                ]
                            ]
                        ],
                        "hero" => [
                            "type" => "image",
                            "margin" => "none",
                            "url" => $note_image,
                            "size" => "full",
                            "aspectRatio" => "2000:1000",
                            "aspectMode" => "cover",
                            "action" => [
                                "type" => "uri",
                                "uri" => $note_link
                            ]
                        ],
                        "body" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "spacing" => "sm",
                            "contents" => [
                                [
                                    "type" => "text",
                                    "text" => $note_title,
                                    "size" => "md",
                                    "weight" => "bold",
                                    "wrap" => true,
                                    "color" => "#555555",
                                ],
                                [
                                    "type" => "text",
                                    "text" => $note_author,
                                    "size" => "sm",
                                    "weight" => "bold",
                                    "wrap" => true,
                                    "color" => "#555555",
                                ],
                                [
                                    "type" => "text",
                                    "text" => $note_content,
                                    "size" => "xs",
                                    "wrap" => true,
                                    "color" => "#555555",
                                    "margin" => "md"
                                ]
                            ]
                        ],
                        "footer" => [
                            "type" => "box",
                            "layout" => "horizontal",
                            "contents" => [
                                [
                                    "type" => "button",
                                    "action" => [
                                        "type" => "uri",
                                        "label" => "See more",
                                        "uri" => $note_link
                                    ],
                                    "height" => "sm",
                                    "color" => "#9999bb",
                                    "style" => "primary"
                                ]
                            ]
                        ],
                    ]
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
    }
}
