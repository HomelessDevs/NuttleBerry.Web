<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Course;
use App\Models\Task;
use App\Models\Answer;
use App\Models\MyCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{

    public function index()
    {
        $groups = DB::table('groups')->get();
        return response()->json($groups, 200);
    }

    public function store(Request $request)
    {

        $group = DB::table('groups')->insert([
            'name' => $request->name,
        ]);
        return response()->json($group, 200);
    }

    public function show($id)
    {
        $group = DB::table('groups')->where('id', '=', $id)->first();
        return response()->json($group, 200);
    }

    public function update(Request $request, $id)
    {
        $group = DB::table('groups')->where('id', $id)->update([
            'name' => $request->name,
        ]);
        return response()->json($group, 200);
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
        return response()->json('success', 200);
    }
}
