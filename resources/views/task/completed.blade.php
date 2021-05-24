@extends('templates.main-template')
@section('content')
    @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
        <div>
            <h1 class="answers-task-title">{{$task->title}}</h1>
            @if(!empty($task->deadline_date && $task->deadline_time))
                <p class="deadline-date-time"><span
                            class="purple">термін здачі:</span> {{ $task->deadline_date }} {{ mb_substr($task->deadline_time, 0, 5) }}
                </p>
            @endif
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
                    <div class="answer-block {{$answer->id}} @if($answer->status == 'Оцінено') green-border @elseif($answer->status == 'Не оцінено') yellow-border @endif">
                        <div class="user-answer-info">
                            @if($answer->message != "none")
                                <div class="circle-author">
                                    <div class="author-answer-status">
                                        <div class="answer-author">
                                            @foreach($users as $user)
                                                @if($user->id == $answer->user_id)
                                                    <p>{{$user->name}}</p>
                                                    @break
                                                @endif
                                            @endforeach
                                                <span class="purple">{{ date('F j', strtotime(mb_substr($answer->created_at, 0, 10))) }}</span>
                                        </div>

                                    </div>
                                    <div class="circle-deadline">
                                        <span class="rating-task">{{$answer->rating}}/{{$task->max_rating}}</span>
                                    @if($task->deadline_date >= mb_substr($answer->created_at, 0, 10) && strtotime(mb_substr($task->deadline_time, 0, 5)) >= strtotime(mb_substr($answer->created_at, 10, 6)))
                                            <div class="deadline-completed">
                                                <div class="circle @if($answer->status == "Не оцінено") orange @elseif($answer->status == "Оцінено") green @endif"></div>
                                            </div>
                                            <span class="purple">{{ mb_substr($task->deadline_time, 0, 5) }}</span>
                                        @else
                                            <div class="deadline-failed">
                                                <div class="circle @if($answer->status == "Не оцінено") orange @elseif($answer->status == "Оцінено") green @endif"></div>
                                                <svg class="svg-time-failed" xmlns="http://www.w3.org/2000/svg"
                                                     id="Capa_1"
                                                     enable-background="new 0 0 443.294 443.294" height="512"
                                                     viewBox="0 0 443.294 443.294" width="512">
                                                    <path d="m221.647 0c-122.214 0-221.647 99.433-221.647 221.647s99.433 221.647 221.647 221.647 221.647-99.433 221.647-221.647-99.433-221.647-221.647-221.647zm0 415.588c-106.941 0-193.941-87-193.941-193.941s87-193.941 193.941-193.941 193.941 87 193.941 193.941-87 193.941-193.941 193.941z"/>
                                                    <path d="m235.5 83.118h-27.706v144.265l87.176 87.176 19.589-19.589-79.059-79.059z"/>
                                                </svg>
                                            </div>
                                            <span class="purple">{{ mb_substr($task->deadline_time, 0, 5) }}</span>

                                        @endif
                                    </div>
                                </div>
                                <div class="answer-message">
                                    @if(!empty($answer->message))
                                        <span class="text-message">{{ $answer->message }}</span>
                                    @else
                                        <span>No message</span>
                                    @endif
                                </div>
                            @endif
                            @if($answer->file != "none")
                                <div class="answer-download">
                                    <a href="{{ route('task.download.completed', $answer->id) }}">{{$answer->file}}</a>
                                </div>
                            @endif
                        </div>
                        @if($answer->status == "Не оцінено")
                        <div class="answer-form">
                            <form class="form" enctype="multipart/form-data" method="post"
                                  action="{{ route('task.rate', $answer->id) }}">
                                @csrf
                                <input type="hidden" name="taskID" value="{{$answer->task_id}}">
                                <textarea name="teacher-feedback"></textarea>
                                <div class="submit-rated-task-rating">
                                    <input required
                                           placeholder="{{$task->max_rating}}"
                                           class="rating-of-task-form"
                                           type="number"
                                           max="{{$task->max_rating}}" min="1" name="rating"
                                           value="{{ $answer->rating }}">
                                    <button class="submit-rated-task-button" type="submit">Оцінити
                                    </button>
                                </div>
                            </form>
                        </div>
                        @elseif($answer->status = "Оцінено")
                            <div class="teacher-feedback-block">
                                <span>Відгук вчителя: {{$answer->teacher_feedback}}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <h2 class="completed-none-answers">Ніхто ще не здав роботи</h2>
        @endif
    @endif
@endsection


