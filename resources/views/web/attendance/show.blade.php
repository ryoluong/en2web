@extends('layouts.app')
@section('title', ' - Attendance')
@section('content')
<div id="showAttendances">
    <table>
        <tr>
            <th>Name</th>
            <th>Group</th>
            @foreach($meetings as $mtg)
            <th>{{ $mtg->name }}</th>
            @endforeach
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->group_id }}</td>
            @foreach($meetings as $mtg)
            @if($attend = App\Attendance::where('user_id', $user->id)->where('meeting_id', $mtg->id)->first())
                @switch($attend->status)
                    @case('attend')
                        <td style="color: #557" class="attend">出席</td>
                        @break
                    @case('absent')
                        <td style="color: #aaa" class="absent">欠席</td>
                        @break
                    @case('late')
                        <td style="color: #779" class="late">遅刻</td>
                        @break
                    @case('early')
                        <td style="color: #779" class="early">早退</td>
                        @break
                    @case('overseas')
                        <td style="color: #0ac" class="overseas">留学</td>
                        @break
                    @case('graduated')
                        <td style="color: #aaa" class="obog">OB</td>
                        @break
                @endswitch
            @else
                        <td style="color: #aaa" class="no-data"> - </td>
            @endif
            @endforeach
        @endforeach
        </tr>
    </table>
</div>
@endsection