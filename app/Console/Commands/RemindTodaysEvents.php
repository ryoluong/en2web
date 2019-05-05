<?php

namespace App\Console\Commands;

use App\Event;
use App\Facades\Line;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemindTodaysEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:remindtodaysevents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Remind Today's Events.";

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
        foreach(Event::where('date', $today)->where('the_day', true)->get() as $event) {
            Line::remindEvent($event, '今日');
        }
    }
}
