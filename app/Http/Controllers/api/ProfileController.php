<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;

class ProfileController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user &&
            Hash::check($request->password, $user->password)) {
            return response()->json($user, 200);
        }
    }

    public function show($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        return response()->json($user, 200);
    }

    public function edit($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $user->name = $request->input('name');
        $user->save();
        return response()->json($user, 200);
    }


    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return response()->json($user, 200);
    }

    public function promote($id)
    {
        $user = User::where('id', $id)->first();
        $user->role = 'teacher';
        $user->save();
        return response()->json($user, 200);
    }
}
