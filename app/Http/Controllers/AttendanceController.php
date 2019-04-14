<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Meeting;
use App\User;
use App\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $mtg = Meeting::where('status', '!=', 'completed')->first();
        return view('web.attendance.index', compact('mtg'));
    }

    public function addMeeting(Request $req)
    {
        if(!Meeting::where('status', '!=', 'completed')->count()) {
            $mtg = Meeting::create([
                'name' => request('name'),
                'status' => 'await'
            ]);
            $overseasUsers = User::where('isOverseas', 1)->get();
            foreach($overseasUsers as $user) {
                Attendance::updateOrCreate([
                    'user_id' => $user->id,
                    'meeting_id' => $mtg->id,
                ],[
                    'status' => 'overseas'
                ]);
            }
        }
        return redirect('/attendance');
    }

    public function toggleMeeting(Meeting $meeting)
    {
        if($meeting->status == 'await') {
            $meeting->status = 'active';
        } else {
            $meeting->status = 'await';
        }
        $meeting->save();
        return redirect('/attendance');
    }

    public function completeMeeting(Meeting $meeting)
    {
        $meeting->status = 'completed';
        $meeting->save();
        return redirect('/attendance');
    }

    public function cancelMeeting(Meeting $meeting)
    {
        $meeting->delete();
        return redirect('/attendance');
    }
}
