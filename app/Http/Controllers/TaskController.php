<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Task;
use App\Models\Answer;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index($course_id)
    {
        $topics = DB::table('tasks')->select('topic')->distinct()->where('course_id', $course_id)->get();
        $tasks = DB::table('tasks')->where('course_id', $course_id)->get();
        $tasksIDs = array();
        foreach ($tasks as $task) {
            $tasksIDs[] = $task->id;
        }
        $completedTasks = DB::table('completed_tasks')->where('user_id', Auth::user()->id)->whereIn('task_id', $tasksIDs)->get();
        $course = DB::table('courses')->where('id', $course_id)->first();
        $MyCourses = DB::table('my_courses')->where([['user_id', Auth::user()->id], ['course_id', $course_id]])->first();
        return view('task.tasks', ['tasks' => $tasks, 'topics' => $topics, 'myCourse' => $MyCourses, 'course' => $course, 'completedTasks' => $completedTasks]);
    }

    public function store(Request $request)
    {
        $task = new Task;
        $task->topic = $request->input('topic');
        $task->title = $request->input('title');
        $task->type = $request->input('type');
        $task->description = nl2br($request->input('message'));
        $task->course_id = $request->input('course');
        if ($request->hasFile('file')) {
            $task->file = $request->file('file')->getClientOriginalName();
            $request->file->storeAs('uploads', $request->file->getClientOriginalName());
        }
        $task->save();

        return redirect()->route('administrating');
    }

    public function show($task_id)
    {
        $task = DB::table('tasks')->where('id', '=', $task_id)->first();
        $course_id = $task->course_id;
        $teacher_id = Course::where('id', $course_id)->select('teacher_id')->first();
        $teacher_name = User::where('id', $teacher_id->teacher_id)->select('name')->first();
        if (Auth::user()->role == "student") {
            $completedTask = DB::table('completed_tasks')->where([
                ['user_id', '=', Auth::user()->id],
                ['task_id', '=', $task_id],
            ])->first();
            return view('task.single-task', ['task' => $task, 'completedTask' => $completedTask, 'teacherName' => $teacher_name->name]);
        } elseif (Auth::user()->role == "teacher" || Auth::user()->role == "admin") {
            $completedTasksRated = count(Answer::where([["task_id", $task_id], ["status", "Оцінено"]])->get());
            $completedTasksNotRated = count(Answer::where([["task_id", $task_id], ["status", "Не оцінено"]])->get());
            return view('task.single-task', ['completedTasksNotRated' => $completedTasksNotRated, "completedTasksRated" => $completedTasksRated, 'task' => $task, 'teacherName' => $teacher_name->name]);
        }
    }

    public function edit($id)
    {
        $groups = DB::table('groups')->get();
        $courses = DB::table('courses')->get();
        $task = DB::table('tasks')->where('id', $id)->first();
        $topics = DB::select('select distinct topic from tasks');
        return view('task.edit-task', ['courses' => $courses, 'groups' => $groups, 'task' => $task, 'topics' => $topics]);
    }

    public function editAnswer(Request $request)
    {
        $answer = Answer::where([
            ['user_id', '=', $request->user_id],
            ['task_id', '=', $request->task_id],
        ])->first();
        $answer->message = $request->input('message');
        $answer->status = "Не оцінено";
        $answer->rating = "-";
        if ($request->hasFile('file')) {
            $answer->file = $request->file('file')->getClientOriginalName();
            $request->file->storeAs('uploads', $request->file->getClientOriginalName());
        }
        $answer->save();
        return redirect()->route('task.show', $request->input('task_id'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::where('id', $id)->first();
        $task->topic = $request->input('topic');
        $task->title = $request->input('title');
        $task->type = $request->input('type');
        $task->description = $request->input('message');
        $task->course_id = $request->input('course');
        if ($request->hasFile('file')) {
            $task->file = $request->file('file')->getClientOriginalName();
            $request->file->storeAs('uploads', $request->file->getClientOriginalName());
        }
        $task->save();
        return redirect()->route('administrating');
    }

    public function destroy($id)
    {
        Task::where('id', $id)->delete();
        return redirect()->route('administrating');
    }

    public function download($id)
    {
        $answer = DB::table('completed_tasks')->where('id', $id)->first();
        return response()->download(storage_path('app/uploads/') . $answer->file);
    }

    public function answer(Request $request)
    {
        $answer = new Answer;
        $answer->user_id = $request->input('user_id');
        $answer->task_id = $request->input('task_id');
        $answer->message = $request->input('message');
        if ($request->hasFile('file')) {
            $answer->file = $request->file('file')->getClientOriginalName();
            $request->file->storeAs('uploads', $request->file->getClientOriginalName());
        }
        $answer->save();
        return redirect()->route('task.show', $request->input('task_id'));
    }

    public function rate(Request $request, $answerID)
    {
        $answer = Answer::where('id', $answerID)->first();
        $answer->rating = $request->input('rating');
        $answer->status = "Оцінено";
        $answer->teacher_feedback = $request->input('teacher-feedback');
        $answer->save();
        return redirect()->route('task.completed', $request->taskID);
    }

    public function completed($task_id)
    {
        $answers = Answer::where('task_id', $task_id)->orderBy('status', 'desc')->get();
        $userIDs = array();
        foreach ($answers as $answer) {
            $userIDs[] = $answer->user_id;
        }
        $users = User::whereIn('id', $userIDs)->get();
        $task = Task::where('id', $task_id)->first();
        return view('task.completed', ['answers' => $answers, 'task' => $task, 'users' => $users]);
    }

    public function journal()
    {
        $answers = DB::table('completed_tasks')->where('user_id', Auth::user()->id)->get();
        $taskIDs = array();
        foreach ($answers as $answer) {
            $taskIDs[] = $answer->task_id;
        }
        $tasks = DB::table('tasks')->whereIn('id', $taskIDs)->get();
        $coursesIDs = array();
        foreach ($tasks as $task) {
            $coursesIDs[] = $task->course_id;
        }
        $courses = DB::table('courses')->select('name', 'id')->whereIn('id', $coursesIDs)->get();
        return view('journal.journal', ['answers' => $answers, 'tasks' => $tasks, 'courses' => $courses]);
    }
}
