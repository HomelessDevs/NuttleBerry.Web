@extends('templates.main-template')
@section('content')
    <h1>{{$task->title}}</h1>
    <p>{{$task->description}}</p>
    @if($task->file != "none")
        <a href="{{ route('task.download', $task->id) }}">{{$task->file}}</a>
    @endif
    <div class="task-info">
        <div class="task-status">
        <p>status</p>
        </div>
        <div class="task-rating">
            <p>rating</p>
        </div>
        <div class="task-teacher-message">
        <p>message</p>
        </div>
    </div>
    @if(!empty($completedTask) && Auth::user()->id == $completedTask->user_id && request()->task == $completedTask->task_id )
        <div>
            <a href="#">edit answer</a>
            <div class="edit-answer">
                <form enctype="multipart/form-data" method="post"
                      action="{{ route('task.edit.answer', Auth::user()->id) }}">
                    @csrf
                    <input type="text" value="{{ $completedTask->message }}" name="message">
                    <input type="file" name="file">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="task_id" value="{{ $task->id }}">
                    <input type="submit">
                </form>
            </div>
        </div>
    @else
        <form enctype="multipart/form-data" method="post" action="{{ route('task.answer', Auth::user()->id) }}">
            @csrf
            <input type="text" name="message">
            <input type="file" name="file">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <input type="submit">
        </form>
    @endif
    @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
        <a href="{{ route('task.completed', $task->id) }}">rate</a>
    @endif
@endsection
