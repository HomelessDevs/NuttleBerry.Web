<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MyCourses;
use App\Models\Course;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->first();
        $myCourses = MyCourses::where('user_id', Auth::user()->id)->get();
        $course_ids = array();
        foreach ($myCourses as $course) {
            $course_ids[] = $course->course_id;
        }
        $courses = DB::table('courses')->whereIn('id', $course_ids)->get();
        return view('profile.profile', ['user' => $user, 'courses' => $courses]);
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
        if ($request->hasFile('photo')) {
            $user->photo = $request->file('photo');
            $request->photo->storeAs('public', $request->photo);
        }
        $user->save();
        $myCourses = MyCourses::where('user_id', Auth::user()->id)->get();
        $course_ids = array();
        foreach ($myCourses as $course) {
            $course_ids[] = $course->course_id;
        }
        $courses = DB::table('courses')->whereIn('id', $course_ids)->get();
        return view('profile.profile', ['user' => $user, 'courses' => $courses]);
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
