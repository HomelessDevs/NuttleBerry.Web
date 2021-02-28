<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Task;
use App\Models\Answer;
use App\Models\MyCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{

    public function index($group)
    {
        $courses = DB::table('courses')->where('group_id', $group)->get();
        return view('course.courses', ['courses' => $courses]);
    }

    public function myCourses()
    {
        $myCourses = DB::table('my_courses')->where('user_id', Auth::user()->id)->get();
        $course_ids = array();
        foreach ($myCourses as $course) {
            $course_ids[] = $course->course_id;
        }
        $courses = DB::table('courses')->whereIn('id', $course_ids)->get();
        return view('course.my-courses', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
        DB::table('courses')->insert([
            'name' => $request->name,
            'group_id' => $request->group,
        ]);
        return redirect()->route('administrating');
    }

    public function edit($id)
    {
        $groups = DB::table('groups')->get();
        $course = DB::table('courses')->where('id', $id)->first();
        return view('course.edit-course', ['course' => $course, 'groups' => $groups]);
    }

    public function update(Request $request, $id)
    {
        $course = Course::where('id', $id)->first();
        $course->name = $request->input('name');
        $course->group_id = $request->input('group');
        $course->save();
        return redirect()->route('administrating');
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
        return redirect()->route('administrating');
    }

    public function register($courseID)
    {
        $userID = Auth::user()->id;
        $myCourse = new MyCourses;
        $myCourse->user_id = $userID;
        $myCourse->course_id = $courseID;
        $myCourse->save();
        $course = Course::where('id', $courseID)->first();
        return redirect()->route("task.index", $course->id);
    }
}
