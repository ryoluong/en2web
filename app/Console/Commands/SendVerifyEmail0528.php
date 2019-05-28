<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\EmailVerification;
use App\User;
use Illuminate\Support\Facades\Mail;

class SendVerifyEmail0528 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:verify0528';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '20190528メールの再送信';

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
        $users = User::where('status', 0)->get();
        foreach($users as $user) {
            $email = new EmailVerification($user);
            try {
                Mail::to($user->email)->send($email);
            } catch (Exception $e) {
                $this->info('Failed to send email! UserId='. $user->id);
            }
            $this->info("Email sent to {$user->email}");
        }
    }
}
