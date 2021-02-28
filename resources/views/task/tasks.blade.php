@extends('templates.main-template')
@section('content')
    @if(isset($myCourse))
        <h1>{{request()->route()->parameter('name')}}</h1>
        <ul>
            @foreach ($topics as $topic)
                {{ $topic->topic }}
                @foreach($tasks as $task)
                    @if($task->topic == $topic->topic)
                        <li>
                            <a href="{{ route('task.show', [$task->id]) }}">{{ $task->title }}</a>
                        </li>
                    @endif
                @endforeach
            @endforeach
        </ul>
        @if(count($tasks)==0)
            <p>No tasks</p>
        @endif
    @else
        <a href="{{ route('course.register', $course->id) }}">register</a>
    @endif
@endsection
