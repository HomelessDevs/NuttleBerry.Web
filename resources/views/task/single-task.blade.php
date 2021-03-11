@extends('templates.main-template')
@section('content')
    <h1>{{$task->title}}</h1>
    <div class="task-wrap">
        <div class="task-teacher">
            <p>Teacher:Adison Maksvel</p>
        </div>
        <div class="task-description-info">
            <p>{{$task->description}}</p>
            @if($task->file != "none")
                <a href="{{ route('task.download', $task->id) }}">{{$task->file}}</a>
            @endif
        </div>
        <div class="task-answer">
            <div class="teacher-feedback">
                    <p>Відгук вчителя: rem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recent</p>
            </div>
            <div>

            </div>
            <div class="task-info">
                <div class="task-info-status">
                    <div>
                        <p>status:</p>
                    </div>
                    <div>
                        <p>pending</p>
                    </div>
                </div>
                <div class="task-info-rating">
                    <div>
                        <p>rating:</p>
                    </div>
                    <div>
                        <p>5/5</p>
                    </div>
                </div>
                <div class="task-button-edit">
                    @if(!empty($completedTask) && Auth::user()->role == "student")
                    <button>Редагувати відповідь</button>
                    @elseif(empty($completedTask)&& Auth::user()->role == "student")
                            <button>Відповісти</button>
                        @endif
                    @if(Auth::user()->role == "teacher" && !empty($completedTask) || Auth::user()->role == "admin" && !empty($completedTask))
                            <button>Оцінити</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="edit-task">
            @if(!empty($completedTask) && Auth::user()->id == $completedTask->user_id && request()->task == $completedTask->task_id )
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
            @else
                <form enctype="multipart/form-data" method="post"
                      action="{{ route('task.answer', Auth::user()->id) }}">
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
        </div>
    </div>
@endsection
