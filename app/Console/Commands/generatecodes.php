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
        if($num > 100) {
            $this->error('Number of codes generate should be less than 100.');
        } else {
            for($i = 0; $i < $num; $i++) {
                $code = Code::create([
                    'code' => $this->getRandomString(12)
                ]);
                $this->line($code->code);
            }
            $this->info("{$num} codes successfully generated.");
        }
    }
    private function getRandomString($num)
    {
        $chars = '23456789abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $randomString = '';
        for($i = 0; $i < $num; $i++) {
            $randomString .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $randomString;
    }
}
