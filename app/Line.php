<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
            'to' => config('const.LINE_MY_USER_ID'),
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
}
