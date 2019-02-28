<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slack extends Model
{
    private $url = 'https://hooks.slack.com/services/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';
    
    public function notice(string $str) {
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
        $response = file_get_contents($this->url, false, stream_context_create($options));
        return $response;
    }
}
