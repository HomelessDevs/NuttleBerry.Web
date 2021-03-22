@extends('templates.main-template')
@section('content')
    <h1>{{$task->title}}</h1>
    <div class="task-wrap">
        <div class="task-teacher">
            <p>Викладач: {{ $teacherName }}</p>
        </div>
        <div class="task-description-info">
            <p>{{$task->description}}</p>
            @if($task->file != "none")
                <a href="{{ route('task.download', $task->id) }}">{{$task->file}}</a>
            @endif
        </div>
        @if($task->type == "practice")
        <div>
            <div class="task-answer">
                @if(Auth::user()->role == "student")
                    @if(isset($completedTask) )
                        <div class="teacher-feedback">
                            <p>
                                @if($completedTask->status == "Не оцінено")
                                    <span>Ваша робота ще не оцінена</span>
                                @elseif($completedTask->status == "Оцінено")
                                    @if($completedTask->teacher_feedback != "none")
                                        <span>Відгук вчителя:</span> {{$completedTask->teacher_feedback}}
                                    @else
                                        Ваша робота
                                        оцінена
                                    @endif
                                @endif</p>
                        </div>
                    @endif
                @endif
                <div
                    class="task-info @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin") teacher-task-info @endif ">
                    @if(Auth::user()->role == "student")
                        <div class="task-info-status">
                            <div>
                                <p>Статус:</p>
                            </div>
                            <div>
                                <p class=" @if($completedTask) @if($completedTask->status == "Оцінено") rated @elseif($completedTask->status == "Не оцінено") pending  @endif @endif">@if($completedTask)
                                        {{ $completedTask->status }}
                                    @else
                                        Не здано
                                    @endif</p>
                            </div>
                        </div>
                        <div class="task-info-rating">
                            <div>
                                <p>Оцінка:</p>
                            </div>
                            <div>
                                <p @if($completedTask) class="rated-task" @endif >@if($completedTask)
                                        {{ $completedTask->rating }}/{{ $task->max_rating }}
                                    @else
                                        -
                                    @endif</p>
                            </div>
                        </div>
                    @endif
                    @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
                        <div class="task-info-status">
                            <div>
                                <p>Здано робіт:</p>
                            </div>
                            <div>
                                <p>{{ $completedTasksNotRated + $completedTasksRated }}</p>
                            </div>
                        </div>
                        <div class="task-info-status">
                            <div>
                                <p>Оцінено:</p>
                            </div>
                            <div>
                                <p>{{ $completedTasksRated .  "/" . ($completedTasksRated + $completedTasksNotRated)  }}</p>
                            </div>
                        </div>
                    @endif
                    <div class="task-button-edit">
                        @if(!empty($completedTask) && Auth::user()->role == "student")
                            <button id="task-button"><span>Редагувати відповідь</span></button>
                        @elseif(empty($completedTask)&& Auth::user()->role == "student")
                            <button id="task-button"><span>Відповісти</span></button>
                        @endif
                        @if(Auth::user()->role == "teacher" && $completedTasksNotRated != 0 || Auth::user()->role == "admin" && $completedTasksNotRated != 0 || Auth::user()->role == "teacher" && $completedTasksNotRated == 0 || Auth::user()->role == "admin" && $completedTasksNotRated == 0)
                            <a href="{{ route('task.completed', $task->id) }}">
                                <button class="task-button-rate" id="task-button"><span>Оцінити</span></button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <div id="edit-task" class="none-displayed">
                @if(!empty($completedTask) && Auth::user()->role == "student" )
                    <div class="edit-answer">
                        <form enctype="multipart/form-data" method="post"
                              action="{{ route('task.edit.answer', Auth::user()->id) }}">
                            @csrf
                            <div class="task-form">
                            <textarea class="textarea-task-form" type="text"
                                      name="message">{{ $completedTask->message  }}</textarea>
                                <div class="drop-zone">
                                    <span class="drop-zone__prompt">Drop file here or click to upload(zip, rar)</span>
                                    <input type="file" name="file" class="drop-zone__input">
                                </div>
                            </div>
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <input class="submit-task-button" type="submit" value="Відпраивти">
                        </form>
                    </div>
                @elseif(empty($completedTask) && Auth::user()->role == "student")
                    <form enctype="multipart/form-data" method="post"
                          action="{{ route('task.answer', Auth::user()->id) }}">
                        @csrf
                        <div class="task-form">
                            <textarea class="textarea-task-form" type="text" name="message"></textarea>
                            <div class="drop-zone">
                                <span class="drop-zone__prompt">Опустіть файл сюди або натисніть, щоб завантажити</span>
                                <input multiple type="file" name="file" class="drop-zone__input">
                            </div>
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input class="submit-task-button" type="submit" value="Надіслати відповідь">
                    </form>
                @endif
            </div>
        </div>
            @endif
    </div>
    <script src="{{ url('js/task-button.js') }}"></script>
    <script src="{{ url('js/drag-and-drop.js') }}"></script>
@endsection

