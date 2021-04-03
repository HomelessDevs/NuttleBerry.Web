<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MyCourses;
use App\Models\Course;
use App\Models\Task;
use App\Models\Answer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show($id)
    {
        $user = User::where('id', '=', $id)->first();
        $course_ids = MyCourses::where('user_id', Auth::user()->id)->pluck('course_id');
        $courses = Course::whereIn('id', $course_ids)->get();
        $user = Auth::user();
        if ($user->role == 'teacher' || $user->role == 'admin') {
            foreach ($courses as $course) {
                if($course->teacher_id == $user->id) {
                    $tasksIDs = Task::where('course_id', $course->id)->pluck('id');
                    $course->count = Answer::whereIn('task_id', $tasksIDs)->where('status', 'Не оцінено')->count();
                }
            }
        }
        $files = Storage::allFiles();
        $photoID = '';
        foreach ($files as $file){
            $fileName = Storage::getMetadata($file);
            if($fileName['name'] == $user->photo){
                $photoID = $file;
            }
        }
        return view('profile.profile', ['user' => $user, 'courses' => $courses, 'photo' => $photoID]);
    }

    public function edit($id)
    {
        $user = User::where('id', '=', $id)->first();
        return view('profile.edit-profile', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:2',
            'surname' => 'required|min:2',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $user = User::where('id', $id)->first();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        if ($request->hasFile('photo')) {
            $files = Storage::allFiles();
            foreach ($files as $file){
                $fileName = Storage::getMetadata($file);
                if($fileName['name'] == $user->photo){
                    Storage::delete($fileName['path']);
                }
            }
            $filename = $request->file('photo')->store('');
            $user->photo = $filename;
        }
        $user->save();
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
