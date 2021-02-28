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
        $courses = DB::table('courses')->get();
        $groups = DB::table('groups')->get();
        $topics = DB::select('select distinct topic from tasks');
        $tasks = DB::select('select distinct * from tasks');
        return view('course-group-list', ['courses' => $courses, 'groups' => $groups, 'topics' => $topics, 'tasks' => $tasks]);
    }
    public function index()
    {
        $courses = DB::table('courses')->get();
        $groups = DB::table('groups')->get();
        return view('group.groups', ['courses' => $courses, 'groups' => $groups]);
    }

    public function store(Request $request)
    {
        DB::table('groups')->insert([
            'name' => $request->name,
        ]);
        return redirect()->route('administrating');
    }

    public function edit($id)
    {
        $group = DB::table('groups')->where('id', $id)->first();
        return view('group.edit-group', ['group' => $group]);
    }

    public function update(Request $request, $id)
    {
        $group = Group::where('id', $id)->first();
        $group->name = $request->input('name');
        $group->save();
        return redirect()->route('administrating');
    }

    public function destroy($id)
    {
        $group = Group::where('id', $id)->select('id')->first();
        Group::where('id', $id)->delete();
        $courses = Course::where('group_id', $group->id)->select('id')->get();
        $coursesIDs = array();
        foreach ($courses as $course) {
            $coursesIDs[] = $course->id;
        }
        MyCourses::whereIn('course_id', $coursesIDs)->delete();
        Course::where('group_id', $group->id)->delete();
        $tasks = Task::where('course_id', $coursesIDs)->get();
        $tasksIDs = array();
        foreach ($tasks as $task) {
            $tasksIDs[] = $task->id;
        }
        Task::whereIn('course_id', $coursesIDs)->delete();
        Answer::whereIn('task_id', $tasksIDs)->delete();
        return redirect()->route('administrating');
    }
}
