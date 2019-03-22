<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{

    public function notice(string $str)
    {
        $url = 'https://api.line.me/v2/bot/message/push';
        $channelToken = 'sv/RKt1C3qskQg0Uh5Xdll9aXWvy42rty+y9gdYtQjzQ5AOMMKOgPPU6yTAuxkoRsTXsWVSmv648F5wXHJzpvWPCkUSnfdjuxj91YZIr7Np4rGPlgFFbsAFeyuL6I8nUFSYZCQvvEZkfHngYPfAtUgdB04t89/1O/w1cDnyilFU=';
        $headers = [
            'Authorization: Bearer ' . $channelToken,
            'Content-Type: application/json; charset=utf-8',
        ];
        $content = json_encode([
            'to' => 'C41cf84a10b0bb1c546d925d74e295b60',
            'messages' => [
                [
                    'type' => 'flex', 
                    'altText' => 'thi is a flex message',
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
