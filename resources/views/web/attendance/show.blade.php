@extends('layouts.app')
@section('title', ' - Attendance')
@section('content')
<div id="showAttendances">
    <div class="loading-wrapper" v-show="loading">
        <div class="loading"></div>
    </div>
    @if($activeMeeting && !auth()->user()->isOverseas && !auth()->user()->isOB)
        <attendance-form :active_meeting="{{ $activeMeeting }}" default_answer="{{ $answer }}" v-show="!loading"></attendance-form>
    @endif
    <div class="main">
        <div class="fix">
            <table class="table table-username">
                <tr class="tr">
                    <th class="th">
                        <p class="title">Attendance</p>
                        <p class="title">Record</p>
                    </th>
                </tr>
                <tr class="tr">
                    <td class="td name rate">出席率</td>
                </tr>
                @foreach($users as $user)
                <tr class="tr">
                    <td class="td name">{{ $user->name }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="scroll">
            <table class="table table-scroll">
                <tr class="tr tr-top">
                    <!-- <th class="th name">Name</th> -->
                    <th class="th group">Group</th>
                    <th class="th mtg">
                        <p class="mtg-name">出席率</p>
                    </th>
                    @foreach($meetings as $mtg)
                    <th class="th mtg">
                        <p class="mtg-name">{{ $mtg->name }}</p>
                    </th>
                    @endforeach
                </tr>
                <tr class="tr">
                    <td class="td group rate"> - </td>
                    <td class="td group rate" style="color: #000000;"> - </td>
                    @foreach($meetings as $mtg)
                    <td class="td rate">{{ $mtg->attend_rate ? $mtg->attend_rate . '%' : ' - ' }}</td>
                    @endforeach
                </tr>
                @foreach($users as $user)
                <tr class="tr">
                    <td class="td group">{{ $user->group_id }}</td>
                    <td class="td mtg ">{{ $user->attendanceRate ? $user->attendanceRate . '%' : ' - ' }}</td>
                    @foreach($meetings as $mtg)
                        @if(
                            $attendance = current(array_filter(
                                $attendances,
                                function($attendance) use ($user, $mtg) {
                                    return $attendance['user_id'] == $user->id
                                        && $attendance['meeting_id'] == $mtg->id;
                                }
                            ))
                        )
                            <td class="td mtg {{ $attendance['status']}}">
                                {{ $attendance['status_jp'] }}
                            </td>
                            <!-- @switch($attendance['status'])
                            @case('attend')
                            <td style="color: #337" class="td mtg attend">出席</td>
                            @break
                            @case('absent')
                            <td style="color: #ccc" class="td mtg absent">欠席</td>
                            @break
                            @case('late')
                            <td style="color: #779" class="td mtg late">遅刻</td>
                            @break
                            @case('early')
                            <td style="color: #779" class="td mtg early">早退</td>
                            @break
                            @case('overseas')
                            <td style="color: #bdf" class="td mtg overseas">留学</td>
                            @break
                            @endswitch -->
                        @else
                            <td style="color: #ccc" class="td mtg no-data"> - </td>
                        @endif
                    @endforeach
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
@endsection