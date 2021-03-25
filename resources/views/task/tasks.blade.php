@extends('templates.main-template')
@section('content')
    <h1>{{ $course->name }}</h1>
    @if(isset($myCourse))

        @foreach ($topics as $topic)
            <div class="topic-list">
                <h2>{{ $topic->topic }}</h2>
                <ul class="task-list">
                    @foreach($tasks as $task)
                        @if($task->topic == $topic->topic)

                            <li>
                                @foreach ($completedTasks as $completed)
                                    @if($completed->task_id == $task->id)
                                        <span class="completed-task-rating">
                                        @if($completed->rating == "-")

                                        @else
                                                {{ $completed->rating }}/{{ $task->max_rating }}
                                        @endif
                                            </span>
                                    @endif
                                @endforeach
                                <a
                                    @foreach ($completedTasks as $completed)
                                        @if($completed->task_id == $task->id)
                                            @if($completed->rating == "-")
                                                class="pending-task"
                                            @else
                                                class="completed-task"
                                            @endif
                                        @endif
                                    @endforeach
                                    @if($task->type == "advertisement")
                                        class="advertisement"
                                    @endif
                                    @if($task->type == "theory")
                                    class="theory"
                                    @endif
                                href="{{ route('task.show', [$task->id]) }}">{{ $task->title }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endforeach

        @if(count($tasks)==0)
            <p>No tasks</p>
        @endif
    @else
        <div class="register-btn">
        <a href="{{ route('course.register', $course->id) }}"><button class="btn">Зареєструватися на курс</button></a>
        </div>
    @endif
@endsection
