<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Task;
use App\Models\Group;
use App\Models\Answer;
use App\Models\MyCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Mail;

class CourseController extends Controller
{

    public function index($group_id)
    {
        $group = Group::findOrFail($group_id);
        $courses = $group->courses;
        $user = Auth::user();
        if ($user->role == 'teacher' || $user->role == 'admin') {
            foreach ($courses as $course) {
                if($course->teacher_id == $user->id) {
                    $tasksIDs = Task::where('course_id', $course->id)->pluck('id');
                    $course->count = Answer::whereIn('task_id', $tasksIDs)->where('status', 'Не оцінено')->count();
                }
            }
        }
        return view('course.courses', ['courses' => $courses, 'groupName' => $group->name]);
    }

    public function myCourses()
    {
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
        return view('course.my-courses', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|min:3',
            'group' => 'required'
        ]);
        $teacherID = Auth::user()->id;
        $course = new Course;
        $course->teacher_id = $teacherID;
        $course->group_id = $request->group;
        $course->name = $request->name;
        $course->save();
        $myCourse = new MyCourses;
        $myCourse->user_id = $teacherID;
        $myCourse->course_id = $course->id;
        $myCourse->save();
        return redirect()->route('administrating')->with('message', 'Курс успішно додано');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $groups = Group::all();
        return view('course.edit-course', ['course' => $course, 'groups' => $groups]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|min:3',
            'group' => 'required'
        ]);
        $course = Course::findOrFail($id);
        $teacherID = Auth::user()->id;
        $course->name = $request->input('name');
        $course->teacher_id = $teacherID;
        $course->group_id = $request->input('group');
        $course->save();
        return redirect()->route('administrating')->with('message', 'Курс успішно відредаговано');
    }

    public function destroy($id)
    {
        Course::where('id', $id)->delete();
        return redirect()->route('administrating')->with('message', 'Курс успішно видалено');
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
