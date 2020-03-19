<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class SyncSlackImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slack:syncimage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync slack users image';

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
        foreach(User::all() as $u) {
            if($u->syncUserImage()) {
                $this->info("User image synced: {$u->name}");
            }
        }
    }
}
