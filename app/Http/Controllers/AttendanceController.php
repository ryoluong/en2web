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
            ->get();
        $activeMeeting = $meetings->where('status', 'active')->first();

        if ($activeMeeting) {
            $answer = $attendances
                ->where('user_id', auth()->user()->id)
                ->where('meeting_id', $activeMeeting->id)
                ->first()
                ->status ?: 'none';
        } else {
            $answer = 'none';
        }
        
        foreach ($users as $user) {
            if ($attendances->where('user_id', $user->id)->where('status', '!=', 'overseas')->count()) {
                $user->attendanceRate = round(
                    $attendances->where('user_id', $user->id)->whereIn('status', ['attend', 'late', 'early'])->count() /
                    $attendances->where('user_id', $user->id)->where('status', '!=', 'overseas')->count() * 100, 1
                );
            }
        }
        
        foreach ($meetings as $mtg) {
            $attends = $attendances->where('meeting_id', $mtg->id);
            $numAttendUser = $attends->whereIn('status', ['attend', 'late', 'early'])->count();
            $numActiveUser = $mtg->status == 'completed'
            ? $attends->where('status', '!=', 'overseas')->count()
            : $users->where('isOverseas', 0)->count();
            $mtg->attend_rate = round($numAttendUser / $numActiveUser * 100, 1);
        }

        return view('web.attendance.show', compact('users', 'meetings', 'activeMeeting', 'attendances', 'answer'));
    }
}
