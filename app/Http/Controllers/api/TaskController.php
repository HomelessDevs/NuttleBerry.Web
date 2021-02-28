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

class TaskController extends Controller
{
    public function index()
    {
        $tasks = DB::table('tasks')->get();
        return response()->json($tasks, 200);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file')->getClientOriginalName();
            $request->file->storeAs('uploads', $request->file->getClientOriginalName());
        }
        else{
            $file = 'none';
        }
        $task = DB::table('tasks')->insert([
            'topic' => $request->topic,
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->message,
            'course_id' => $request->course,
            'file' => $file,
        ]);
        return response()->json($task, 200);
    }

    public function show($id)
    {
        $task = DB::table('tasks')->where('id', '=', $id)->first();
        return response()->json($task, 200);
    }

    public function update(Request $request, $id)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file')->getClientOriginalName();
            $request->file->storeAs('uploads', $request->file->getClientOriginalName());
        }
        else{
            $file = 'none';
        }
        $task = DB::table('tasks')->where('id', $id)->update([
            'topic' => $request->topic,
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->message,
            'course_id' => $request->course,
            'file' => $file,
        ]);
        return response()->json($task, 200);
    }
    public function destroy($id)
    {
        Task::where('id', $id)->delete();
        Answer::where('task_id', $id)->delete();
        return response()->json('success', 200);
    }
    ////////////////////////////////////ANSWERS////////////////////////////////////
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
        return response()->json($answer, 200);
    }

    public function rate(Request $request, $answerID)
    {
        $answer = Answer::where('id', $answerID)->first();
        $answer->rating = $request->input('rating');
        $answer->save();
        return response()->json($answer, 200);
    }

    public function completed($task_id)
    {
        $answers = DB::table('completed_users_tasks')->where('task_id', $task_id)->get();
        return response()->json($answers, 200);
    }
}
