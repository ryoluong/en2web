<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Facades\Line;
use App\Meeting;
use Carbon\Carbon;

class NoticeAttendanceDeadline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:noticeattendancedeadline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notice deadline of meeting attendance.';

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
        $today = Carbon::today()->toDateString();
        if (Meeting::where('status', 'active')->where('deadline', $today)->exists()) {
            $mtg = Meeting::where('status', 'active')->where('deadline', $today)->first();
            Line::attendance($mtg, 'deadline');
        }
    }
}
