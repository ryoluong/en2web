<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Facades\Slack;

class IntegrateSlackUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slack:linkusers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Integrate slack users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $token = config('const.SLACK_BOT_OAUTH_TOKEN');
        $options = [
            'http' => [
                'method'  => 'GET',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
            ]
        ];
        $context = stream_context_create($options);
        $response = json_decode(file_get_contents("https://slack.com/api/users.list?token={$token}", false, $context));
        foreach ($response->members as $member) {
            $names = explode(' ', $member->profile->real_name);
            if (count($names) < 2) {
                continue;
            }
            $pattern1 = $names[0] . ' ' . $names[1];
            $pattern2 = $names[1] . ' ' . $names[0];
            $user = User::where(function ($query) use ($pattern1, $pattern2) {
                    $query
                        ->where('name', 'LIKE', $pattern1)
                        ->orWhere('name', 'LIKE', $pattern2);
                })
                ->whereNull('slack_id')
                ->first();
            if ($user) {
                $user->slack_id = $member->id;
                if($user->save()) {
                    $message =
"*あなたのSlackアカウントが、En2::Webと連携されました!*
```
【En2::Web ユーザー情報】
入学: {$user->year}年
所属: {$user->department}
氏名: {$user->name}
```
万が一、上記のアカウントが自分以外のものである場合は、<@US5GTG60K> までご連絡ください！";
                    Slack::inbox($user->slack_id, $message);
                    Slack::notice($user->name .' has been linked to En2::Web!');
                    $this->info($user->name .' has been linked to En2::Web!');
                }
            }
        }
    }
}
