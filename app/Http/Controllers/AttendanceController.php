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
        return redirect('/attendance/manager');
    }

    public function toggleMeeting(Meeting $meeting)
    {
        if($meeting->status == 'await') {
            $meeting->status = 'active';
        } else {
            $meeting->status = 'await';
        }
        $meeting->save();
        return redirect('/attendance/manager');
    }

    public function completeMeeting(Meeting $meeting)
    {
        $users = User::where('isOB', 0)->where('isOverseas', 0)->get();
        foreach($users as $user) {
            Attendance::firstOrCreate([
                'user_id' => $user->id,
                'meeting_id' => $meeting->id,
            ],[
                'status' => 'absent'
            ]);
        }
        $meeting->status = 'completed';
        $meeting->save();
        return redirect('/attendance');
    }

    public function cancelMeeting(Meeting $meeting)
    {
        $meeting->delete();
        return redirect('/attendance/manager');
    }

    public function attend(Request $req)
    {
        $mtg_id = Meeting::where('status', 'active')->first()->id;
        $user_id = auth()->user()->id;
        Attendance::updateOrCreate([
            'user_id' => $user_id,
            'meeting_id' => $mtg_id,
        ],[
            'status' => request('status')
        ]);
        return redirect('/attendance');
    }

    public function showResults()
    {
        $users = User::where('isOB', 0)->where('isOverseas', 0)->orderBy('group_id')->get();
        // $users = User::orderBy('group_id')->get();
        $meetings = Meeting::all();
        $attendances = Attendance::all();
        foreach($meetings as $mtg) {
            if($mtg->status == 'completed') {
                $attends = $attendances->where('meeting_id', $mtg->id);
                $numActiveUser = $attends->where('status', '!=', 'overseas')->count();
                $numAttendUser = $attends->where('status', '=', 'attend')->count();
                $numLateEarlyUser = $attends->whereIn('status', ['late', 'early'])->count();
                $mtg->attend_rate = round(($numAttendUser + $numLateEarlyUser * 0.5) / $numActiveUser * 100, 1);
            } else {
                $mtg->attend_rate = '';
            }
        }
        return view('web.attendance.show', compact('users', 'meetings', 'attendances'));
    }
}
