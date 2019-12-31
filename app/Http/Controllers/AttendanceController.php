<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\Line;
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
        $req->validate([
            'name' => ['max:20'],
            'date' => ['required'],
            'time' => ['required'],
        ]);
        if (!Meeting::where('status', '!=', 'completed')->count()) {
            $mtg = Meeting::create([
                'name' => request('name'),
                'date' => request('date'),
                'start_time' => request('time'),
                'status' => 'active',
                'deadline' => request('deadline', null)
            ]);
            $overseasUsers = User::where('isOverseas', 1)->get();
            foreach ($overseasUsers as $user) {
                Attendance::updateOrCreate([
                    'user_id' => $user->id,
                    'meeting_id' => $mtg->id,
                ], [
                    'status' => 'overseas'
                ]);
            }
            if (request('line_notice')) {
                Line::attendance($mtg, 'start');
            }
        }
        return redirect('/attendance/manager');
    }

    public function completeMeeting(Meeting $meeting)
    {
        $users = User::where('isOB', 0)->where('isOverseas', 0)->get();
        foreach ($users as $user) {
            Attendance::firstOrCreate([
                'user_id' => $user->id,
                'meeting_id' => $meeting->id,
            ], [
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
        ], [
            'status' => request('status')
        ]);
    }

    public function showResults()
    {
        $meetings = collect(
            Meeting::select('id', 'name', 'status')
                ->orderBy('created_at', 'desc')
                ->take(6)
                ->get()
            )->reverse();
        $users = User::select('id', 'group_id', 'name')
            ->where('isOB', 0)
            ->whereIn('status', [1,3])
            ->orderBy('group_id')
            ->get();
        $attendances = Attendance::select('user_id', 'meeting_id', 'status')
            ->whereIn('meeting_id', $meetings->pluck('id'))
            ->get()
            ->toArray();
        $activeMeeting = $meetings->where('status', 'active')->first();

        if ($activeMeeting) {
            $answer = current(array_filter(
                $attendances, 
                function($attendance) use ($activeMeeting) {
                    return $attendance['user_id'] == auth()->user()->id 
                        && $attendance['meeting_id'] == $activeMeeting->id;
                }
            ))['status'] ?: 'none';
        } else {
            $answer = 'none';
        }
        
        foreach ($users as $user) {
            $numTotal = count(array_filter(
                $attendances,
                function($attendance) use ($user) {
                    return $attendance['user_id'] == $user->id
                        && $attendance['status'] != 'overseas';
                }
            ));
            $numAttend = count(array_filter(
                $attendances,
                function($attendance) use ($user) {
                    return $attendance['user_id'] == $user->id
                        && $attendance['status'] != 'overseas' 
                        && $attendance['status'] != 'absent';
                }
            ));
            if ($numTotal) {
                $user->attendanceRate = round($numAttend / $numTotal * 100, 1);
            }
        }
        
        foreach ($meetings as $mtg) {
            $numAttendUser = count(array_filter(
                $attendances,
                function($attendance) use ($mtg) {
                    return $attendance['meeting_id'] == $mtg->id
                        && $attendance['status'] != 'overseas' 
                        && $attendance['status'] != 'absent';
                }
            ));
            if ($mtg->status == 'completed') {
                $numActiveUser = count(array_filter(
                    $attendances,
                    function($attendance) use ($mtg) {
                        return $attendance['meeting_id'] == $mtg->id
                            && $attendance['status'] != 'overseas';
                    }
                ));
            } else {
                $numActiveUser = $users->where('isOverseas', 0)->count();
            }
            $mtg->attend_rate = round($numAttendUser / $numActiveUser * 100, 1);
        }
        return view('web.attendance.show', compact('users', 'meetings', 'activeMeeting', 'attendances', 'answer'));
    }
}
