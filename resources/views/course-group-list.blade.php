@extends('templates.main-template')
@section('content')
    <h1 xmlns="http://www.w3.org/1999/html">Створення курсів</h1>
    <div class="create-courses-btns">
        <div>
            <button onclick="displayForm(this)" class="new-btn selected-btn" id="group-btn">Додати групу</button>
        </div>
        <div>
            <button onclick="displayForm(this)" class="new-btn" id="course-btn">Додати курс</button>
        </div>
        <div>
            <button onclick="displayForm(this)" class="new-btn" id="task-btn">Додати завдання</button>
        </div>
    </div>
    <div class="course-group-form">
        <div class="new-form" id="group-form">
            <form method="POST" action="{{ route('group.store')}}">
                @csrf
                <label for="name">Назва</label>
                <input required name="name" type="text">
                <button class="btn" type="submit">Додати</button>
            </form>
            <ul>
                @foreach($groups as $group)
                    <li>
                        <div><a href="{{ route('group.index', $group->id) }}">{{ $group->name }}</a></div>
                        <div><a
                                href="{{ route('group.edit', $group->id) }}"> edit</a></div>
                @endforeach
            </ul>
        </div>
        <div class="new-form none-displayed" id="course-form">
            <form method="POST" action="{{ route('course.store')}}">
                @csrf
                <label>Назва</label>
                <input required name="name" type="text">

                <input name="teacher_id" type="hidden" value="{{ Auth::user()->id }}">
                <label>Група</label>

                <select name="group">

                    @foreach ($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                    @endforeach
                </select>
                <button class="btn" type="submit">Додати</button>
            </form>
            <ul>
                @foreach($courses as $course)
                    <li>
                        <div><a href="{{ route('course.index', $course->id) }}">{{ $course->name }}</a></div>
                        <div><a
                                href="{{ route('course.edit', $course->id) }}"> edit</a></div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="new-form none-displayed" id="task-form">
            <form enctype="multipart/form-data" method="POST" action="{{ route('task.store')}}">
                @csrf
                <label>Курси</label>

                <select name="course">
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                    @endforeach
                </select>
                <label>Теми</label>
                <input name="topic" list="topic">
                <datalist id="topic">
                    @foreach ($topics as $topic)
                        <option value="{{$topic->topic}}">
                    @endforeach
                </datalist>

                <label>Назва</label>
                <input required name="title" type="text">

                <label>Тип</label>

                <select name="type">
                    <option value="practice">practice</option>
                    <option value="theory">theory</option>
                    <option value="advertisement">advertisement</option>
                </select>
                <label>Максимальний бал</label>
                <input required name="max_rating" type="number" min="1">
                <label>Опис завдання</label>
                <textarea name="message" required></textarea>
                <label>Файл</label>
                <div class="drop-zone create-task-drop-input">
                    <span class="drop-zone__prompt">Drop file here or click to upload(zip, rar)</span>
                    <input accept=".zip, .rar" type="file" name="file" class="drop-zone__input">
                </div>

                <button class="btn" type="submit">Додати</button>
            </form>
            <ul>
                @foreach($tasks as $task)
                    <li>
                        <div><a href="{{ route('task.show', $task->id) }}">{{ $task->title }}</a></div>
                        <div><a
                                href="{{ route('task.edit', $task->id) }}"> edit</a></div>

                    </li>
                @endforeach
            </ul>
            <script src="{{ url('js/new-btn.js') }}"></script>
        </div>
    </div>
    <script src="{{ url('js/drag-and-drop.js') }}"></script>

@endsection
