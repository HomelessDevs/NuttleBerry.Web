@extends('templates.main-template')
@section('content')
    @if($task->file != "none")
        <a href="{{ route('task.download', $task->id) }}">{{$task->file}}</a>
    @endif
    @if(!empty($completedTask) && Auth::user()->id == $completedTask->user_id && request()->task == $completedTask->task_id )
        <h3>Task complete</h3>
        <a href="#">edit answer</a>
        <form enctype="multipart/form-data" method="post" action="{{ route('task.edit.answer', Auth::user()->id) }}">
            @csrf
            <input type="text" value="{{ $completedTask->message }}" name="message">
            <input type="file" name="file">
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <input type="hidden" name="task_id" value="{{ $task->id }}">
            <input type="submit">
        </form>
    @else
        <h1>{{$task->title}}</h1>
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
