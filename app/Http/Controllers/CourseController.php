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
        $group = Group::find($group_id);
        $courses = $group->courses;
        return view('course.courses', ['courses' => $courses, 'groupName' => $group->name]);
    }
    public function myCourses()
    {
        $myCourses = MyCourses::where('user_id', Auth::user()->id)->get();
        $course_ids = array();
        foreach ($myCourses as $course) {
            $course_ids[] = $course->course_id;
        }
        $courses = DB::table('courses')->whereIn('id', $course_ids)->get();
        return view('course.my-courses', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
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
        return redirect()->route('administrating')->with('message', 'Курс успішно додано');;
    }

    public function edit($id)
    {
        $groups = DB::table('groups')->get();
        $course = DB::table('courses')->where('id', $id)->first();
        return view('course.edit-course', ['course' => $course, 'groups' => $groups]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:30',
            'group' => 'required'
        ]);
        $course = Course::where('id', $id)->first();
        $course->name = $request->input('name');
        $course->group_id = $request->input('group');
        $course->save();
        return redirect()->route('administrating')->with('message', 'Курс успішно відредаговано');
    }

    public function destroy($id)
    {
        Course::where('id', $id)->delete();
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
