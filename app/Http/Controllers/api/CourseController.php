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

class CourseController extends Controller
{

    public function index()
    {
        $courses = DB::table('courses')->get();
        return response()->json($courses, 200);
    }

    public function store(Request $request)
    {
        $course = DB::table('courses')->insert([
            'name' => $request->name,
            'group_id' => $request->group,
        ]);
        return response()->json($course, 200);
    }

    public function show($id)
    {
        $course = DB::table('courses')->where('id', '=', $id)->first();
        return response()->json($course, 200);
    }

    public function update(Request $request, $id)
    {
        $course = DB::table('groups')->where('id', $id)->update([
            'name' => $request->name,
            'group_id' => $request->group,
        ]);
        return response()->json($course, 200);
    }

    public function destroy($id)
    {
        $course = Course::where('id', $id)->select('name', 'id')->first();
        MyCourses::where('course_id', $course->id)->delete();
        Course::where('id', $id)->delete();
        $tasks = Task::where('course_id', $course->id)->get();
        $tasksIDs = array();
        foreach ($tasks as $task) {
            $tasksIDs[] = $task->id;
        }
        Task::where('course_id', $course->id)->delete();
        Answer::whereIn('task_id', $tasksIDs)->delete();
        return response()->json('success', 200);
    }
}
