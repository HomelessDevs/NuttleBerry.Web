<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Course;
use App\Models\Task;
use App\Models\Answer;
use App\Models\MyCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
    public function administrating()
    {
        $groups = Group::all();
        $courses = Course::where('teacher_id', Auth::user()->id)->get();
        $coursesIDs = array();
        foreach ($courses as $course){
            $coursesIDs[] = $course->id;
        }
        $tasks = Task::whereIn('course_id', $coursesIDs)->get();
        $topics = DB::select('select distinct topic from tasks');
        return view('course-group-list', ['courses' => $courses, 'groups' => $groups, 'topics' => $topics, 'tasks' => $tasks]);
    }
    public function index()
    {
        $courses = Course::all();
        $groups = Group::all();
        return view('group.groups', ['courses' => $courses, 'groups' => $groups]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
        ]);
        Group::insert([
            'name' => $request->name,
        ]);
        $userID = Auth::user()->id;
        /*
        $myCourse = new MyCourses;
        $myCourse->user_id = $userID;
        $myCourse->course_id = $courseID;
        $myCourse->save();
        */
        return redirect()->route('administrating')->with('message', 'Групу успішно додано');
    }

    public function edit($id)
    {
        $group = Group::where('id', $id)->first();
        return view('group.edit-group', ['group' => $group]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
        ]);
        $group = Group::where('id', $id)->first();
        $group->name = $request->input('name');
        $group->save();
        return redirect()->route('administrating')->with('message', 'Групу успішно відредаговано');
    }

    public function destroy($id)
    {
        Group::where('id', $id)->delete();
        return redirect()->route('administrating');
    }
}
