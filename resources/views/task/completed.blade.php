@extends('templates.main-template')
@section('content')
    @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
        @foreach($answers as $answer)
            <p>{{$answer->message}}</p>
            <a href="{{ route('task.download', $answer->task_id) }}">{{$answer->file}}</a>
            <form enctype="multipart/form-data" method="post" action="{{ route('task.rate', $answer->id) }}">
                @csrf
                <input type="text" name="rating" value="{{ $answer->rating }}">
                <input type="hidden" name="taskID" value="{{$answer->task_id}}">
                <input type="submit">
            </form>
        @endforeach

    @endif
@endsection


