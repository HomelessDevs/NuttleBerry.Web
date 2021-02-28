@extends('templates.main-template')
@section('content')
    <div class="course-group-form">
        <div class="group-form">
            <h2><a>create group</a></h2>
            <form method="POST" action="{{ route('group.store')}}">
                @csrf
                <label>name
                    <input required name="name" type="text">
                </label>
                <input type="submit">
            </form>
            <ul>
                @foreach($groups as $group)
                    <li><a href="{{ route('group.edit', $group->id) }}">{{ $group->name }}</a>
                        <form method="post"
                              action="{{route('group.destroy', $group->id)}}"> {{ method_field('DELETE') }}
                            @csrf<input value="destroy" type="submit"></form>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="course-from">
            <h2><a>create course</a></h2>
            <form method="POST" action="{{ route('course.store')}}">
                @csrf
                <label>name
                    <input required name="name" type="text">
                </label>
                <label>group
                    <select name="group">
                        @foreach ($groups as $group)
                            <option value="{{$group->id}}">{{$group->name}}</option>
                        @endforeach
                    </select>
                </label>
                <input type="submit">
            </form>
            <ul>
                @foreach($courses as $course)
                    <li><a href="{{ route('course.edit', $course->id) }}">{{ $course->name }}</a>
                        <form method="post"
                              action="{{route('course.destroy', $course->id)}}"> {{ method_field('DELETE') }}
                            @csrf<input value="destroy" type="submit"></form>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="task-form">
            <h2><a>create task</a></h2>
            <form enctype="multipart/form-data" method="POST" action="{{ route('task.store')}}">
                @csrf
                <label>course
                    <select name="course">
                        @foreach ($courses as $course)
                            <option value="{{$course->id}}">{{$course->name}}</option>
                        @endforeach
                    </select>
                </label>
                <label>topic
                    <input name="topic" list="topic">
                    <datalist id="topic">
                        @foreach ($topics as $topic)
                            <option value="{{$topic->topic}}">
                        @endforeach
                    </datalist>
                </label>
                <label>title
                    <input required name="title" type="text">
                </label>
                <label>type
                    <select name="type">
                        <option value="practice">practice</option>
                        <option value="theory">theory</option>
                        <option value="advertisement">advertisement</option>
                    </select>
                </label>
                <br>
                <label>message
                    <input required name="message" type="text">
                </label>
                <label>file
                    <input name="file" type="file">
                </label>
                <input type="submit">
            </form>
            <ul>
                @foreach($tasks as $task)
                    <li><a href="{{ route('task.show', $task->id) }}">{{ $task->title }}</a><a href="{{ route('task.edit', $task->id) }}"> edit</a>
                        <form method="post"
                              action="{{route('task.destroy', $task->id)}}"> {{ method_field('DELETE') }}
                            @csrf<input value="destroy" type="submit"></form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
