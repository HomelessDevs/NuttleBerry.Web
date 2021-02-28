<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        return view('profile.profile', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        return view('profile.edit-profile', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $request->input('name');
        $user->save();
        return view('profile.profile', ['user' => $user]);
    }


    public function destroy($id)
    {
        User::find($id)->delete();
    }

    public function promote($id)
    {
        $user = User::where('id', $id)->first();
        $user->role = 'teacher';
        $user->save();
        return view('profile.profile', ['user' => $user]);
    }
}
