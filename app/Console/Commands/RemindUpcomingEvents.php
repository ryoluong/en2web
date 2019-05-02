<?php

namespace App\Console\Commands;

use App\Event;
use App\Facades\Line;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RemindUpcomingEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:remindupcomingevents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind upcoming events, except ones will be held in the day.';

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
        $one_month_after = Carbon::today()->addMonth()->toDateString();
        $two_weeks_after = Carbon::today()->addWeeks(2)->toDateString();
        $one_week_after = Carbon::today()->addWeeks(1)->toDateString();
        $tomorrow = Carbon::today()->addDay()->toDateString();
        foreach(Event::where('date', $one_month_after)->where('one_month_before', true)->get() as $event) {
            Line::remindEvent($event);
        }
        foreach(Event::where('date', $two_weeks_after)->where('two_weeks_before', true)->get() as $event) {
            Line::remindEvent($event);
        }
        foreach(Event::where('date', $one_week_after)->where('one_week_before', true)->get() as $event) {
            Line::remindEvent($event);
        }
        foreach(Event::where('date', $tomorrow)->where('the_day_before', true)->get() as $event) {
            Line::remindEvent($event);
        }
    }
}
