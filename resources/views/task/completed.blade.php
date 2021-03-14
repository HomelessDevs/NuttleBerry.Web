@extends('templates.main-template')
@section('content')
    @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
        <div class="answers-blocks-wrap">
            @foreach($answers as $answer)
                <div class="answer-block">

                    <div class="user-answer-info">
                        @if($answer->message != "none")
                            <div class="answer-author">
                                @foreach($users as $user)
                                    @if($user->id == $answer->user_id)
                                        <p>{{$user->name}}</p>
                                        @break
                                    @endif
                                @endforeach
                            </div>
                            <div class="answer-message">
                                <p>{{$answer->message}}</p>
                            </div>
                        @endif
                        @if($answer->file != "none")
                            <div class="answer-download">
                                <a href="{{ route('task.download', $answer->id) }}">{{$answer->file}}</a>
                            </div>
                        @endif
                    </div>
                    <div class="answer-form">
                        <form class="form" enctype="multipart/form-data" method="post"
                              action="{{ route('task.rate', $answer->id) }}">
                            @csrf
                            <input type="hidden" name="taskID" value="{{$answer->task_id}}">
                            <textarea name="teacher-feedback">{{$answer->teacher_feedback}}</textarea>
                            <div class="submit-rated-task-rating">
                                <input class="rating-of-task-form" type="number" max="5" min="1" name="rating"
                                       value="{{ $answer->rating }}">
                                <input value="Оцінити" type="submit" class="submit-rated-task-button">
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection


