<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Code;

class generatecodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:generate {num}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate registration codes.';

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
        $num = $this->argument('num');
        for($i = 0; $i < $num; $i++) {
            Code::create([
                'code' => getRandomString(12)
            ]);
        }
    }
}
