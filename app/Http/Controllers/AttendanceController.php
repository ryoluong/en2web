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
        if (!Meeting::where('status', '!=', 'completed')->count()) {
            $mtg = Meeting::create([
                'name' => request('name'),
                'status' => 'await'
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
        }
        return redirect('/attendance/manager');
    }

    public function toggleMeeting(Meeting $meeting)
    {
        if ($meeting->status == 'await') {
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
        $users = User::where('isOB', 0)->where('isOverseas', 0)->orderBy('group_id')->get();
        $meetings = Meeting::all();
        $attendances = Attendance::all();
        $lateEarlyWeight = 1; // 遅刻・早退の比重

        foreach ($users as $user) {
            if ($attendances->where('user_id', $user->id)->where('status', '!=', 'overseas')->count()) {
                $user->attendanceRate =
                    round(($attendances->where('user_id', $user->id)->where('status', 'attend')->count() +
                    $attendances->where('user_id', $user->id)->whereIn('status', ['late', 'early'])->count() * $lateEarlyWeight) /
                    $attendances->where('user_id', $user->id)->where('status', '!=', 'overseas')->count() * 100, 1);
            }
        }

        foreach ($meetings as $mtg) {
            if ($mtg->status == 'completed') {
                $attends = $attendances->where('meeting_id', $mtg->id);
                $numActiveUser = $attends->where('status', '!=', 'overseas')->count();
                $numAttendUser = $attends->where('status', '=', 'attend')->count();
                $numLateEarlyUser = $attends->whereIn('status', ['late', 'early'])->count();
                $mtg->attend_rate = round(($numAttendUser + $numLateEarlyUser * $lateEarlyWeight) / $numActiveUser * 100, 1);
            } else {
                $attends = $attendances->where('meeting_id', $mtg->id);
                $numActiveUser = $users->count();
                $numAttendUser = $attends->where('status', '=', 'attend')->count();
                $numLateEarlyUser = $attends->whereIn('status', ['late', 'early'])->count();
                $mtg->attend_rate = round(($numAttendUser + $numLateEarlyUser * $lateEarlyWeight) / $numActiveUser * 100, 1);
            }
        }

        if ($attendances->where('status', '!=', 'overseas')->count() && !$meetings->whereIn('status', ['active','await'])->count()) {
            $totalAttendanceRate = round(
                ($attendances->where('status', 'attend')->count() +
                 $attendances->whereIn('status', ['late', 'early'])->count() * $lateEarlyWeight) /
                 $attendances->where('status', '!=', 'overseas')->count() * 100,
                1
                );
        } else {
            $totalAttendanceRate = '';
        }

        return view('web.attendance.show', compact('users', 'meetings', 'attendances', 'totalAttendanceRate'));
    }
}
