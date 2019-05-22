<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResizeCoverImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resize:coverimage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resize user cover image';

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
            if($user->coverimg_path) {
                $image = \Image::make(public_path('storage') . $user->coverimg_path);
                $image
                    ->resize(null, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    })
                    ->save(public_path('storage') . $user->coverimg_path);
                $this->line($user->name);
            }
        }
    }
}
