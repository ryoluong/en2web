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
                return 'ユーザーの作成に失敗しました。時間をおいて再度お試しください。';
            }
            $email = $res->profile->email;
            $user->email = $email;
            $user->email_verify_token = base64_encode($email);
            if ($user->save()) {
                Mail::to($email)->send(new EmailVerification($user));
                Slack::notice("Pre-Registered: `" . $res->profile->real_name . "`");
                return "`{$email}` 宛に仮登録完了メールを送信しました。メールを確認して登録を進めてください。";
            }
            return 'ユーザーの作成に失敗しました。時間をおいて再度お試しください。';
        });
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
