@extends('templates.main-template')
@section('content')
    @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
        <div>
            <h1 class="answers-task-title">{{$task->title}}</h1>
            @if(session()->has('message'))
                <div class="message-success">
                    <p>{{ session()->get('message') }}</p>
                </div>
            @elseif(session()->has('message-warning'))
                <div class="message-warning">
                    <p>{{ session()->get('message-warning') }}</p>
                </div>
            @endif
        </div>
        @foreach ($errors->all() as $error)
            <li><p class="error-text">{{ $error }}</p></li>
        @endforeach
        @if(isset($answers[0]))
            <div class="answers-blocks-wrap">
                @foreach($answers as $answer)
                    <div class="answer-block {{$answer->id}}">

                        <div class="user-answer-info">
                            @if($answer->message != "none")
                                <div class="author-answer-status">
                                    <div class="answer-author">
                                        @foreach($users as $user)
                                            @if($user->id == $answer->user_id)
                                                <p>{{$user->name}}</p>
                                                @break
                                            @endif
                                        @endforeach
                                    </div>
                                    <div
                                        class="circle @if($answer->status == "Не оцінено") orange @elseif($answer->status == "Оцінено") green @endif"></div>
                                </div>
                                <div class="answer-message">
                                    <p>{{$answer->message}}</p>
                                </div>
                            @endif
                            @if($answer->file != "none")
                                <div class="answer-download">
                                    <a href="{{ route('task.download.completed', $answer->id) }}">{{$answer->file}}</a>
                                </div>
                            @endif
                        </div>
                        <div class="answer-form">
                            <form class="form" enctype="multipart/form-data" method="post"
                                  action="{{ route('task.rate', $answer->id) }}">
                                @csrf
                                <input type="hidden" name="taskID" value="{{$answer->task_id}}">
                                <textarea @if($answer->status == "Оцінено") disabled @endif name="teacher-feedback">@if($answer->teacher_feedback == "none")@else{{ $answer->teacher_feedback }}@endif</textarea>
                                <div class="submit-rated-task-rating">
                                    <input @if($answer->status == "Оцінено") disabled @endif required placeholder="{{$task->max_rating}}" class="rating-of-task-form" type="number"
                                           max="{{$task->max_rating}}" min="1" name="rating"
                                           value="{{ $answer->rating }}">
                                    <button @if($answer->status == "Оцінено") disabled class="submit-rated-task-button disabled" @else class="submit-rated-task-button" @endif type="submit" >Оцінити</button>
                                </div>

                            </form>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <h2 class="completed-none-answers">Ніхто ще не здав роботи</h2>
        @endif
    @endif
@endsection


