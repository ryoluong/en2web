<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResizeUserAvater extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resize:avater';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resize avater';

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
        $users = \App\User::all();
        foreach($users as $user) {
            if($user->avater_path) {
                $image = \Image::make(public_path() . $user->avater_path);
                if ($image->width() >= $image->height()) {
                    $image
                        ->resize(null, 250, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save(public_path() . $user->avater_path);
                } else {
                    $image
                        ->resize(250, null, function ($constraint) {
                            $constraint->aspectRatio();
                        })
                        ->save(public_path() . $user->avater_path);
                }
                $this->line("{$user->name}'s avater resized.");
            }
        }
    }
}
