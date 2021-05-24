<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Task;
use App\Models\Answer;
use App\Models\Course;
use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mail;
use App\Models\MyCourses;

class TaskController extends Controller
{
    public function index($course_id)
    {
        $course = Course::findOrFail($course_id);
        $topics = DB::table('tasks')->select('topic')->distinct()->where('course_id', $course_id)->get();
        $tasks = Task::where('course_id', $course_id)->get();
        $tasksIDs = $tasks->pluck('id');
        $completedTasks = DB::table('completed_tasks')->where('user_id', Auth::user()->id)->whereIn('task_id', $tasksIDs)->get();

        $MyCourses = MyCourses::where([['user_id', Auth::user()->id], ['course_id', $course_id]])->first();
        if (Auth::user()->id == $course->teacher_id) {
            $tasksIndicationValues = array();
            foreach ($tasks as $task) {
                $completedTasksRated = count(Answer::where([["task_id", $task->id], ["status", "Оцінено"]])->get());
                $completedTasksNotRated = count(Answer::where([["task_id", $task->id], ["status", "Не оцінено"]])->get());
                if($task->type == "theory"){
                    $tasksIndicationValues[$task->id] = "theory";
                }
                elseif ($completedTasksRated == 0 && $completedTasksNotRated == 0) {
                    $tasksIndicationValues[$task->id] = "none";
                    }
                elseif ($completedTasksNotRated > 0){
                    $tasksIndicationValues[$task->id] = "pending";
                }
                elseif($completedTasksRated > 0 && $completedTasksNotRated == 0){
                    $tasksIndicationValues[$task->id] = "ready";
                }

            }
            return view('task.tasks', ['tasks' => $tasks, 'topics' => $topics, 'myCourse' => $MyCourses, 'course' => $course, 'completedTasks' => $completedTasks,'teacherTasksStatus' => $tasksIndicationValues]);
        } else {
            return view('task.tasks', ['tasks' => $tasks, 'topics' => $topics, 'myCourse' => $MyCourses, 'course' => $course, 'completedTasks' => $completedTasks]);
        }
    }

    public function store(Request $request)
    {
        $today = date('Y-m-d');
        $validated = $request->validate([
            'topic' => 'required|max:100|min:3',
            'title' => 'required|max:100|min:3',
            'message' => 'required|max:2000|min:3',
            'type' => 'required',
            'course' => 'required',
            'max_rating' => 'required|max:5|min:1',
            'file' => '|mimes:zip,rar|max:5048',
            'deadline' => '|date|date_format:Y-m-d|after:today',
        ]);
        $task = new Task;
        $task->topic = $request->input('topic');
        $task->title = $request->input('title');
        $task->type = $request->input('type');
        $task->description = nl2br($request->input('message'));
        $task->course_id = $request->input('course');
        $task->max_rating = $request->input('max_rating');
        $task->deadline_date = $request->input('deadline_date');
        $task->deadline_time = $request->input('deadline_time');
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->store('');
            $task->file = $filename;
        }
        $task->save();

        return redirect()->route('administrating')->with('message', 'Завдання успішно додано');
    }

    public function show($task_id)
    {
        $task = Task::findOrFail($task_id);
        $course_id = $task->course_id;
        $teacher_id = Course::where('id', $course_id)->select('teacher_id')->first();
        $teacher = User::where('id', $teacher_id->teacher_id)->select('name', 'id')->first();
        if (Auth::user()->id != $teacher->id) {


            $answer = Answer::where([['task_id', $task_id], ['user_id', Auth::user()->id]])->get();


            $completedTask = Answer::where([
                ['user_id', '=', Auth::user()->id],
                ['task_id', '=', $task_id],
            ])->first();
            return view('task.single-task', ['task' => $task, 'completedTask' => $completedTask, 'teacher' => $teacher]);
        } elseif (Auth::user()->id == $teacher->id) {
            $completedTasksRated = count(Answer::where([["task_id", $task_id], ["status", "Оцінено"]])->get());
            $completedTasksNotRated = count(Answer::where([["task_id", $task_id], ["status", "Не оцінено"]])->get());
            return view('task.single-task', ['completedTasksNotRated' => $completedTasksNotRated, "completedTasksRated" => $completedTasksRated, 'task' => $task, 'teacher' => $teacher]);
        }
    }

    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $groups = Group::all();
        $courses = Course::where('teacher_id', Auth::user()->id)->get();
        $topics = DB::select('select distinct topic from tasks');
        return view('task.edit-task', ['courses' => $courses, 'groups' => $groups, 'task' => $task, 'topics' => $topics]);
    }

    public function editAnswer(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'task_id' => 'required',
            'message' => 'required|max:150',
            'file' => '|mimes:zip,rar|max:2048'
        ]);
        $answer = Answer::where([
            ['user_id', '=', $request->user_id],
            ['task_id', '=', $request->task_id],
        ])->first();
        if (empty($answer)){
            return redirect('404');
        }
        $answer->message = $request->input('message');
        $answer->status = "Не оцінено";
        $answer->rating = "-";
        if ($request->hasFile('file')) {
            /*
            $file = $request->file('file');
            $imagePath = $request->file('file')->getClientOriginalName();
            $filename = pathinfo($imagePath, PATHINFO_FILENAME);
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
            if (Storage::disk('google')->exists('$answer->file')) {
                Storage::disk('google')->delete($answer->file);
            }
            $answer->file = $filename . time() . '.' . $extension;
            */
            $files = Storage::allFiles();
            foreach ($files as $file){
                $fileName = Storage::getMetadata($file);
                if($fileName['name'] == $answer->file){
                    Storage::delete($fileName['path']);
                }
            }
            $filename = $request->file('file')->store('');
            $answer->file = $filename;
        }
        $answer->save();
        return redirect()->route('task.show', $request->input('task_id'))->with('message', 'Ваша відповіль успішно відредаговано');
    }

    public function update(Request $request, $id)
    {
        $today = date('Y-m-d');
        $validated = $request->validate([
            'topic' => 'required|max:100|min:3',
            'title' => 'required|max:100|min:3',
            'message' => 'required|max:2000|min:3',
            'course' => 'required',
            'max_rating' => 'required|max:5|min:1',
            'file' => '|mimes:zip,rar|max:5048',
            'deadline' => '|date|date_format:Y-m-d|after:today',
        ]);
        $task = Task::findOrFail($id);
        $task->topic = $request->input('topic');
        $task->title = $request->input('title');
        $task->description = $request->input('message');
        $task->course_id = $request->input('course');
        $task->max_rating = $request->input('max_rating');
        $task->deadline = $request->input('deadline');
        $task->deadline_time = $request->input('deadline_time');
        if ($request->hasFile('file')) {
            $files = Storage::allFiles();
            foreach ($files as $file){
                $fileName = Storage::getMetadata($file);
                if($fileName['name'] == $task->file){
                    Storage::delete($fileName['path']);
                }
            }
            $filename = $request->file('file')->store('');
            $task->file = $filename;
        }
        $task->save();
        return redirect()->route('administrating')->with('message', 'Завдання успішно відредаговано');
    }

    public function destroy($id)
    {
        Task::where('id', $id)->delete();
        return redirect()->route('administrating')->with('message', 'Завдання успішно видалено');
    }

    public function downloadCompletedTask($id)
    {
        $answer = Answer::findOrFail($id);
        $files = Storage::allFiles();
        $fileID = null;
        foreach ($files as $file){
            $fileName = Storage::getMetadata($file);
            if($fileName['name'] == $answer->file){
                $fileID = $fileName['path'];
            }
        }
        return Storage::download($fileID, 'yes'. '.' . $fileName['extension']);
    }

    public function downloadTask($id)
    {
        $answer = Task::findOrFail($id);
        $files = Storage::allFiles();
        $fileID = null;
        foreach ($files as $file){
            $fileName = Storage::getMetadata($file);
            if($fileName['name'] == $answer->file){
                $fileID = $fileName['path'];
            }
        }
        return Storage::download($fileID, 'yes'. '.' . $fileName['extension']);
    }

    public function answer(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'task_id' => 'required',
            'message' => 'required|',
            'file' => '|mimes:zip,rar|max:2048'
        ]);
        $answer = new Answer;
        $answer->user_id = $request->input('user_id');
        $answer->task_id = $request->input('task_id');
        $answer->message = $request->input('message');
        if ($request->hasFile('file')) {
            $filename = $request->file('file')->store('');
            $answer->file = $filename;
        }
        $task = Task::where('id', $answer->task_id)->first();
        $answer->save();
        $data = array('task' => $task);
        Mail::send(['text' => 'mail'], $data, function ($message) use ($task) {
            $message->to('tarnavskij2002@gmail.com', 'Tutorials Point')->subject
            ('Здане завдання');
            $message->from('tarnavskij2002@gmail.com', 'Петро Олексійович');
        });
        DB::table('completed_users_tasks')->insert(['user_id' => Auth::user()->id,'task_id' => $answer->task_id]);
        return redirect()->route('task.show', $answer->task_id)->with('message', 'Ваша робота успішно відправлена на перевірку');
    }

    public function rate(Request $request, $answerID)
    {
        $validated = $request->validate([
            'teacher-feedback' => 'max:150',
            'rating' => 'required',
        ]);
        $answer = Answer::findOrFail($answerID);
        if($answer->status == 'Не оцінено') {
            $task = Task::where('id', $answer->task_id)->first();
            $validated = $request->validate([
                'rating' => 'required|numeric|max:' . $task->max_rating,
                'teacher_feedback' => 'max:150',
            ]);
            $answer->rating = $request->input('rating');
            $answer->status = "Оцінено";
            if ($request->input('teacher-feedback') == null) {
                $answer->teacher_feedback = "none";
            } else {
                $answer->teacher_feedback = $request->input('teacher-feedback');
            }
            $answer->save();
            $user = User::where('id', $answer->user_id)->first();
            $teacher = Auth::user();
            $data = array('email' => $user, 'teacher' => $teacher, 'task' => $task);
            Mail::send(['text' => 'mail'], $data, function ($message) use ($user, $teacher, $task) {
                $message->to($user->email, $user->name . ' ' . $user->surname)->subject
                ('Вашу роботу з "' . $task->title . '" оцінено');
                $message->from($teacher->email, $teacher->name . ' ' . $teacher->surname);
            });
            return redirect()->route('task.completed', $request->taskID)->with('message', 'Робота успішно оцінена');
        }
        elseif ($answer->status == "Оцінено"){
            return redirect()->route('task.completed', $request->taskID);
        }
    }

    public function completed($task_id)
    {
        $task = Task::findOrFail($task_id);
        $answers = Answer::where('task_id', $task_id)->orderBy('status', 'desc')->get();
        $userIDs = $answers->pluck('user_id');
        $users = User::whereIn('id', $userIDs)->get();
        return view('task.completed', ['answers' => $answers, 'task' => $task, 'users' => $users]);
    }

    public function journal()
    {
        $answers = Answer::where('user_id', Auth::user()->id)->get();
        $taskIDs = $answers->pluck('task_id');
        $tasks = Task::whereIn('id', $taskIDs)->get();
        $coursesIDs = $tasks = pluck('course_id');
        $courses = Course::select('name', 'id')->whereIn('id', $coursesIDs)->get();
        return view('journal.journal', ['answers' => $answers, 'tasks' => $tasks, 'courses' => $courses]);
    }
}
