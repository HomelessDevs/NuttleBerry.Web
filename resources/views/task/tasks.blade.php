@extends('templates.main-template')
@section('content')
    @if(isset($myCourse))
        <h1>{{ $course->name }}</h1>

        @foreach ($topics as $topic)
            <div class="topic-list">
                <h2>{{ $topic->topic }}</h2>
                <ul class="task-list">
                    @foreach($tasks as $task)
                        @if($task->topic == $topic->topic)
                            <li>
                                <a href="{{ route('task.show', [$task->id]) }}">{{ $task->title }}</a></li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endforeach

        @if(count($tasks)==0)
            <p>No tasks</p>
        @endif
    @else
        <a href="{{ route('course.register', $course->id) }}">register</a>
    @endif
@endsection
