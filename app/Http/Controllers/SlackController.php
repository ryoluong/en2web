<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\User;

class SlackController extends Controller
{

    const URL_VERIFICATION = "url_verification";
    const COMMAND_IAM = "iam";

    public function command()
    {
        if($this->verifyToken(request('token'))) {
            $args = preg_split('/[[:blank:]]/', request('text'));
            switch($args[0]){
                case self::COMMAND_IAM:
                    return $this->iam($args, request('user_id'));
                default:
                    return $this->help();
            }
        } else {
            return response()->json(
                ['error' => 'token invalid'], 
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    private function iam($args, $slack_id)
    {
        $user = User::where('slack_id', $slack_id)->first();
        if ($user) {
            $message = "Hi, {$user->name}! あなたのEn2::Webアカウントは既にSlackと連携済です。";
        } else if (count($args) === 1) {
            $message = 'メールアドレスを入力してください。';
        } else {
            $user = User::where('email', $args[1])->first();
            if (!$user) {
                $message = 'そのメールアドレスで登録されているユーザーはいません。打ち間違えや、別のメールアドレスを利用していないか確認してください。';
            } else {
                $user->slack_id = $slack_id;
                $user->save();
                $message = "Hi, {$user->department}の {$user->name} さん！あなたのEn2::WebアカウントがSlackと連携されました！";
            }
        }
        return response()->json(['text' => $message]);
    }

    private function help() {
        return response()->json(
            ['text' => "[Command List]\niam {your email}\n- En2::Webに登録したメールアドレスを入力してください！あなたのSlackアカウントとEn2::Webのアカウントがリンクされます。（波括弧は不要です）"]
        );
    }

    public function response()
    {
        if ($this->verifyToken(request('token'))) {
            switch(request('type')) {
                case self::URL_VERIFICATION:
                    return response()->json(
                        ['challenge' =>request('challenge')]
                    );
                default:
                    return 'piyopiyo';
            }
        } else {
            return response()->json(
                ['error' => 'token invalid'], 
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    private function verifyToken($incomingToken)
    {
        return $incomingToken && $incomingToken === config('const.SLACK_VERIFICATION_TOKEN');
    }
}
