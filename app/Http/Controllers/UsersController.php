<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Category;
use App\Tag;
use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereIn('status', [1,3])->orderBy('id')->orderBy('generation')->select(
            'id', 'name', 'avater_path', 'generation', 'group_id', 'isOB', 'department_id'
            )->get();
        return view('web.users.index', compact('users'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $orderBy = request('orderBy');
        $q = request('q');

        $user_ids = User::whereIn('status', [1,3])
            ->when($orderBy == 'group_id', function ($query) use ($orderBy) {
                $custom_order = 'field(group_id,';
                for($i = 1; $i <= User::max('group_id'); $i++) {
                    $custom_order .= "$i,";
                }
                $custom_order .= '0,-1),id';
                return $query->orderByRaw($custom_order);
            })
            ->when($orderBy == 'department_id', function($query) use ($orderBy) {
                return $query->where('department_id', '!=', 0)->orderByRaw('department_id,id');
            }, function($query) {
                return $query->orderByRaw('generation,id');
            })
            ->when(!is_null($q), function ($query) use ($q) {
                return $query->where('name', 'LIKE', "%$q%");
            })
            ->pluck('id');
        
        $id_previous = -1;
        $id_next = -1;
        $index = $user_ids->search($user->id);
        if($index != 0) {
            $id_previous = $user_ids[$index - 1];
        }
        if($index != count($user_ids) - 1) {
            $id_next = $user_ids[$index + 1];
        }
        $flag = 'user';
        $user->university = $user->getEscapedStringWithBr();
        $user->profile = $user->getEscapedProfileWithHeader();
        $notes = $user->notes()->orderBy('date', 'desc')->take(5)->get();
        $queries = '';
        ($orderBy) ? $queries .= "?orderBy=$orderBy" : '';
        ($q) ? $queries .= "&q=$q" : '';
        return view('web.mypage', compact('user', 'id_next','id_previous', 'notes', 'flag', 'queries'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
