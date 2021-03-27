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
        $validated = $request->validate([
            'name' => 'required|min:2',
            'surname' => 'required|min:2',
        ]);
        $user = User::where('id', $id)->first();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->getClientOriginalName();
            $filename = pathinfo($imagePath, PATHINFO_FILENAME);
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            if (file_exists(storage_path("app/public/$user->photo"))) {
                unlink(storage_path("app/public/$user->photo"));
            }
            $user->photo = $filename . time() . '.' . $extension;
            $request->photo->storeAs('public', $user->photo);
        }
        $user->save();
        $myCourses = MyCourses::where('user_id', Auth::user()->id)->get();
        $course_ids = array();
        foreach ($myCourses as $course) {
            $course_ids[] = $course->course_id;
        }
        $courses = DB::table('courses')->whereIn('id', $course_ids)->get();
        return redirect()->route('profile.show', Auth::user()->id)->with('message', 'Данні вашого профілю успішно змінені');
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
