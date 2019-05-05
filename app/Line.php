<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use App\Note;
use App\Event;

class Line extends Model
{
    private $headers;
    private $url;
    private $options;

    public function __construct()
    {
        $this->headers = [
            'Authorization: Bearer ' . config('const.LINE_CHANNEL_TOKEN'),
            'Content-Type: application/json; charset=utf-8',
        ];
        $this->url = 'https://api.line.me/v2/bot/message/push';
        $this->options = [
            'http' => [
                'method' => 'POST',
                'header' => $this->headers,
                'content' => 'here must be filled',
                'ignore_errors' => true,
                'protocol_version' => '1.1'
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ];
    }
    
    private function setOptionContent(string $content)
    {
        $this->options['http']['content'] = $content;
    }

    public function notice(string $str)
    {
        $content = json_encode([
            'to' => config('const.LINE_EN2_KYOYU_GROUP_ID'),
            'messages' => [
                [
                    'type' => 'text', 
                    'text' => $str,
                ],
            ]
        ]);
        $this->setOptionContent($content);
        $response = file_get_contents($this->url, false, stream_context_create($this->options));
        return $response;
    }

    public function remindEvent(Event $event, string $term)
    {
        $event_title = $event->title;
        $weeks = ["日", "月", "火", "水", "木", "金", "土"];
        $date = date_create($event->date);
        $week = $weeks[$date->format('w')];
        $month = $date->format('n');
        $day = $date->format('j');
        $event_timedate = "{$month}月{$day}日 ({$week})";
        if($event->start_time && $event->end_time) {
            $event_timedate .= '  '. preg_replace('/:[0-9]+$/', '', $event->start_time) . '~' . preg_replace('/:[0-9]+$/', '', $event->end_time);
        }
        $event_location = $event->location;
        $alt_text = $term == '明日' || $term == '今日' ? "\u{1F4E3}\u{1F4E3} {$event_title}は{$term}です！" : "\u{1F4E3}\u{1F4E3} {$event_title}まであと{$term}です！";
        $box_content_header = [
            "type" => "text",
            "text" => $term == '明日' || $term == '今日' ? "\u{1F4E3}\u{1F4E3} {$term}です！\u{1F4E3}\u{1F4E3}" : "\u{1F4E3} あと{$term}です！\u{1F4E3}",
            "size" => "xs",
            "wrap" => true,
            "weight" => "bold",
            "color" => "#555555",    
        ];
        $box_content_title = [
            "type" => "text",
            "text" => $event_title,
            "color" => "#333333",
            "size" => "md",
            "weight" => "bold",
            "wrap" => true,
            "margin" => "md"            
        ];
        $box_content_separator = [
            "type" => "separator",
            "color" => "#aaaaaa",
            "margin" => "md"
        ];
        $box_content_timedate = [
            "type" => "text",
            "text" => "\u{1F5D3}  " . $event_timedate,
            "size" => "xs",
            "margin" => "md",
            "wrap" => true,
            "flex" => 1,
            "color" => "#555555"
        ];
        $box_content_location = [
            "type" => "text",
            "text" => "\u{1F4CC}  " . $event_location,
            "size" => "xs",
            "margin" => "sm",
            "wrap" => true,
            "color" => "#555555",
        ];
        $box_contents = [
            $box_content_header, 
            $box_content_title, 
            $box_content_separator, 
            $box_content_timedate,
        ];
        if ($event->location) {
            $box_contents[] = $box_content_location;
        }
        $content = json_encode([
            'to' => config('const.LINE_EN2_GROUP_ID'),
            'messages' => [
                [
                    "type" => "flex",
                    "altText" => $alt_text,
                    "contents" => [
                        "type" => "bubble",
                        "body" => [
                            "type" => "box",
                            "layout" => "vertical",
                            "contents" => $box_contents
                        ],
                    ]
                ],
            ],
        ]);
        $this->setOptionContent($content);
        $response = file_get_contents($this->url, false, stream_context_create($this->options));
        Log::info($response);
    }

    public function note(Note $note, $header_text = 'Notification') 
    {
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
        $this->setOptionContent($content);
        $response = file_get_contents($this->url, false, stream_context_create($this->options));
        Log::info($response);
    }
}
