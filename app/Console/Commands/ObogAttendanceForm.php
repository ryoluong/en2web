<?php

namespace App\Console\Commands;

use App\Facades\Line;
use Illuminate\Console\Command;

class ObogAttendanceForm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notice:obogattendance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $res = Line::obogAttendance();
        $this->info($res);
        $this->info('通知したよ〜');
    }
}
