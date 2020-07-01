<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Note;

class Slack extends Model
{
    const KYOYU_SLACK_CHANNEL_ID = 'CR9AK0BC2';
    const DEBUG_SLACK_CHANNEL_ID = 'CTRPME12M';

    private $client;

    public function __construct()
    {
        $token = config('const.SLACK_BOT_OAUTH_TOKEN');
        $this->client = new \GuzzleHttp\Client([
            'headers' => [
                'Authorization' => "Bearer {$token}"
            ],
        ]);
    }
    public function notice(string $str) {
        $url = config('const.SLACK_WEBHOOK_URI');
        $content = json_encode(array('text' => $str));
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-type: application/json',
                'content' => $content,
                'ignore_errors' => true,
                'protocol_version' => '1.1'
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ];
        return file_get_contents($url, false, stream_context_create($options));
    }

    public function inbox($channel, $message)
    {
        if (app()->isLocal()) {
            $channel = self::DEBUG_SLACK_CHANNEL_ID;
        }
        $url = 'https://slack.com/api/chat.postMessage';
        $headers = [
            'Content-Type' => 'application/json; charset=UTF-8'
        ];
        $content = [
            'channel' => $channel,
            'text' => $message,
        ];
        return $this->client->request('POST', $url, [
            'headers' => $headers,
            'json'    => $content
        ]);
    }

    public function postNote(Note $note)
    {
        $note->loadMissing('photos');
        $channelId = self::KYOYU_SLACK_CHANNEL_ID;
        $channelMentionMsg = "<!channel>\n新しいノートが投稿されました！";
        if ($note->photos()->count()) {
            $this->fileUpload(
                $channelId,
                $note->photos()->first()->path,
                $channelMentionMsg
            );
        } else {
            $this->inbox($channelId, $channelMentionMsg);
        }
        
        if (auth()->user()->slack_id) {
            $userName = "<@" . auth()->user()->slack_id . ">";
        } else {
            $userName = auth()->user()->name;
        }
        $comment = "投稿者：{$userName}\n" . url("notes/{$note->id}");
        $this->postUpload($channelId, $note->title, preg_replace("/\n\n/", "\n\r", $note->content), $comment);
    }

    public function postUpload($channels, $title, $content, $comment)
    {
        if (app()->isLocal()) {
            $channels = self::DEBUG_SLACK_CHANNEL_ID;
        }
        $url = 'https://slack.com/api/files.upload';
        $params = [
            'channels' => $channels,
            'title' => $title,
            'content' => $content,
            'initial_comment' => $comment,
            'filetype' => 'post',
        ];
        return $this->client->request('POST', $url, [
            'form_params' => $params
        ]);
    }

    public function fileUpload($channels, $filePath, $comment)
    {
        if (app()->isLocal()) {
            $channels = self::DEBUG_SLACK_CHANNEL_ID;
        }
        $url = 'https://slack.com/api/files.upload';
        $content = [
            [
                'name' => 'channels',
                'contents' => $channels
            ],
            [
                'name' => 'file',
                'contents' => fopen(str_replace('\\', '/', public_path($filePath)), 'r')
            ],
            [
                'name' => 'initial_comment',
                'contents' => $comment
            ]
        ];
        return $this->client->request('POST', $url, [
            'multipart' => $content
        ]);
    }

    public function fetchUserProfile($slack_id)
    {
        $url = "https://slack.com/api/users.profile.get";
        return $this->client->request('GET', $url, [
            'query' => ['user' => $slack_id]
        ]);
    }
}
