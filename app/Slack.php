<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slack extends Model
{
    const DEBUG_SLACK_CHANNEL_ID = 'CTRPME12M';

    public function notice(string $str) {
        $url = config('const.SLACK_WEBHOOK_URI');
        $content = json_encode(array('text' => $str));
        $options = array (
            'http' => array (
                'method' => 'POST',
                'header' => 'Content-type: application/json',
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

    public function inbox($id, $message)
    {
        if (app()->isLocal()) {
            $id = self::DEBUG_SLACK_CHANNEL_ID;
        }
        $url = 'https://slack.com/api/chat.postMessage';
        $token = config('const.SLACK_BOT_OAUTH_TOKEN');
        $header = implode(PHP_EOL, [
            'Content-type: application/json; charset=UTF-8',
            "Authorization: Bearer {$token}"
        ]);
        $content = json_encode([
            'channel' => $id,
            'text' => $message,
        ]);
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => $header,
                'content' => $content,
                'protocol_version' => '1.1',
                'request_fulluri' => true
            ],
        ];
        file_get_contents($url, false, stream_context_create($options));
    }
}
