<?php

namespace App\Listeners;

use App\Models\Users;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Auth\Events\Login;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = Auth::user();
        if( ! is_null($user))
        {
            $user->last_login_at = Carbon::now();
            $user->login_counter += 1;
            $user->save();
        }
        
    }
}
