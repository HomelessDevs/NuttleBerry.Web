@extends('templates.main-template')
@section('content')
<form enctype="multipart/form-data" method="POST" action="{{ route('task.update', $task->id)}}">
    {{ method_field('PUT') }}
    @csrf
    <label>course
        <select name="course">
            @foreach ($courses as $course)
                <option @if($task->course_id == $course->id) selected @endif value="{{$course->id}}">{{$course->name}}</option>
            @endforeach
        </select>
    </label>
    <label>topic
        <input value="{{ $task->topic }}" name="topic" list="topic">
        <datalist id="topic">
            @foreach ($topics as $topic)
                <option value="{{$topic->topic}}">
            @endforeach
        </datalist>
    </label>
    <label>title
        <input value="{{ $task->title }}" required name="title" type="text">
    </label>
    <label>type
        <select name="type">
            <option @if($task->type == "practice") selected @endif value="practice">practice</option>
            <option @if($task->type== "theory") selected @endif value="theory">theory</option>
            <option @if($task->type == "advertisement") selected @endif value="advertisement">advertisement</option>
        </select>
    </label>
    <br>
    <label>message
        <input value="{{ $task->description }}" required name="message" type="text">
    </label>
    <label>file
        <input value="{{asset("dwa.png")}}" name="file" type="file">
    </label>
    <input type="submit">
</form>
@endsection
