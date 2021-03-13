@extends('templates.main-template')
@section('content')
    @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
        <div class="answers-blocks-wrap">
        @foreach($answers as $answer)
            <div class="answer-block">
                <div class="answer-message">
                    <p>{{$answer->message}}</p>
                </div>
                <div class="answer-download">
                    <a href="{{ route('task.download', $answer->id) }}">{{$answer->file}}</a>
                </div>
                <div class="answer-form">
                    <form enctype="multipart/form-data" method="post" action="{{ route('task.rate', $answer->id) }}">
                        @csrf
                        <input type="text" name="rating" value="{{ $answer->rating }}">
                        <input type="hidden" name="taskID" value="{{$answer->task_id}}">
                        <textarea name="teacher-feedback">{{$answer->teacher_feedback}}</textarea>
                        <input type="submit">
                    </form>
                </div>
            </div>
        @endforeach
        </div>
    @endif
@endsection


