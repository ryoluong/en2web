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
        $users = User::get();
        $max = User::max('generation');
        return view('web.users.index', compact(['users', 'max']));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $id_previous = -1;
        $id_next = -1;
        if(User::whereIn('status', [1,3])->where('id', '>', $user->id)->exists()) {
            $id_next = User::whereIn('status', [1,3])->where('id', '>', $user->id)->min('id');
        }
        if(User::whereIn('status', [1,3])->where('id', '<', $user->id)->exists()) {
            $id_previous = User::whereIn('status', [1,3])->where('id', '<', $user->id)->max('id');
        }
        $notes = $user->notes()->orderBy('date', 'desc')->take(6)->get();
        return view('web.users.show', compact(['user', 'id_next','id_previous', 'notes']));
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
