<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Task;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function index($course_id)
    {
        $topics = DB::table('tasks')->select('topic')->distinct()->where('course_id', $course_id)->get();
        $tasks = DB::table('tasks')->where('course_id', $course_id)->get();
        $course = DB::table('courses')->where('id', $course_id)->first();
        $MyCourses = DB::table('my_courses')->where([['user_id', Auth::user()->id], ['course_id', $course_id]])->first();
        return view('task.tasks', ['tasks' => $tasks, 'topics' => $topics, 'myCourse' => $MyCourses, 'course' => $course]);
    }

    public function store(Request $request)
    {
        $task = new Task;
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

    public function show($task_id)
    {
        $task = DB::table('tasks')->where('id', '=', $task_id)->first();
        $completedTask = DB::table('completed_users_tasks')->where([
            ['user_id', '=', Auth::user()->id],
            ['task_id', '=', $task_id],
        ])->first();
        return view('task.single-task', ['task' => $task, 'completedTask' => $completedTask]);
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
        $answer->message = $request->message;
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
        Answer::where('task_id', $id)->delete();
        return redirect()->route('administrating');
    }

    public function download($id)
    {
        $task = DB::table('tasks')->where('id', $id)->first();
        return response()->download(storage_path('app/uploads/') . $task->file);
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
        $answer->save();
        return redirect()->route('task.completed', $request->taskID);
    }

    public function completed($task_id)
    {
        $answers = DB::table('completed_users_tasks')->where('task_id', $task_id)->get();
        return view('task.completed', ['answers' => $answers]);
    }

    public function journal()
    {
        $answers = DB::table('completed_users_tasks')->where('user_id', Auth::user()->id)->get();
        $taskIDs = array();
        foreach ($answers as $answer) {
            $taskIDs[] = $answer->task_id;
        }
        $tasks = DB::table('tasks')->whereIn('id', $taskIDs)->get();
        $coursesIDs = array();
        foreach ($tasks as $task) {
            $coursesIDs[] = $task->course_id;
        }
        $courses = DB::table('courses')->select('name','id')->whereIn('id', $coursesIDs)->get();
        return view('journal.journal', ['answers' => $answers, 'tasks' => $tasks, 'courses' => $courses]);
    }
}
