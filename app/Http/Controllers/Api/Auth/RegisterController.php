<?php

namespace App\Http\Controllers\Api\Auth;

use App\Facades\Slack;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Mail\RegisterNotification;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function preRegister($slack_id)
    {
        return DB::transaction(function() use ($slack_id) {
            $user = new User(compact('slack_id'));
            $res = $user->fetchSlackProfile();
            if (!$res->ok) {
                return 'Slackユーザー情報の取得に失敗しました。時間をおいて再度お試しください。';
            }
            $email = $res->profile->email;
            $user->email = $email;
            $user->email_verify_token = base64_encode($email);
            if ($user->save()) {
                Slack::notice("Pre-Registered: `" . $res->profile->real_name . "`");
                return $this->inboxRegisterUrl($user);
            }
            return 'ユーザーの作成に失敗しました。時間をおいて再度お試しください。';
        });
    }

    public function inboxRegisterUrl($user)
    {
        $messages = [
            '【En2::Web 登録用URL】',
            '下記URLにアクセスして、登録を続けてください。',
            url("register/verify/$user->email_verify_token"),
            "*このURLはあなた専用です。他の人に教えないでください。"
        ];
        Slack::inbox($user->slack_id, implode("\n", $messages));
        return "登録用URLが送信されました。ダイレクトメッセージをご確認ください。";
    }

    public function verify()
    {
        $user = User::where('email_verify_token', request('token'))->first();
        $ok = $user == true;
        return response()->json(compact('user', 'ok'));
    }

    public function register()
    {
        $user = User::where('email_verify_token', request('token'))->first();
        if ($user->status != 0) {
            return response()->json(
                ['ok' => false],
                Response::HTTP_BAD_REQUEST
            );
        }
        $hashedPassword = Hash::make(request('password'));
        $ok = $user->update(
            request()->except(['token', 'password']) + [
            'password' => $hashedPassword,
            'status' => 1,
            'email_verify_token' => null,
        ]);
        if ($ok) {
            try {
                Mail::to($user->email)->send(new RegisterNotification($user));
                Slack::notice("Register completed: `" . $user->name . "`");
            } catch(Exception $e) {
                Slack::notice($e->getMessage());
            }
        }
        return response()->json([
            'ok' => true,
        ]);
    
    }
}