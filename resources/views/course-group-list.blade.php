@extends('templates.main-template')
@section('content')
    <h1 xmlns="http://www.w3.org/1999/html">Створення курсів</h1>
    <div class="select-edit-create-courses-btns">
        <div>
            <button onclick="displayList(this)" class="new-btn" id="create-course-btn">Створити</button>
        </div>
        <div>
            <button onclick="displayList(this)" class="new-btn" id="edit-course-btn">Редагувати</button>
        </div>
    </div>
    <div id="courses-btns-block" class="create-courses-btns none-displayed">
        <div>
            <button onclick="displayForm(this)" class="new-btn" id="group-btn">Група</button>
        </div>
        <div>
            <button onclick="displayForm(this)" class="new-btn" id="course-btn">Курс</button>
        </div>
        <div>
            <button onclick="displayForm(this)" class="new-btn" id="task-btn">Завдання</button>
        </div>
    </div>
    @if(session()->has('message'))
        <div class="message-success">
            <p>{{ session()->get('message') }}</p>
        </div>
    @endif
    <div id="courses-block" class="course-group-form none-displayed">
        <div class="new-form" id="group-form">
            <form id="group-list-form" method="POST" action="{{ route('group.store')}}">
                @csrf
                @php
                    $inputNames = array('name');
                @endphp
                <ul class="add-new-errors-list">
                    @foreach($inputNames as $name)
                        @error($name)
                        <li>
                            <span class="error-message">{{ $message }}</span>
                        </li>
                        @enderror
                    @endforeach
                </ul>
                <label for="name">Назва</label>
                <input maxlength="30" required name="name" type="text">
                <button class="btn" type="submit">Додати</button>
            </form>
            <ul class="none-displayed" id="group-list">
                @if(isset($groups[0]))
                    @foreach($groups as $group)
                        <li>
                            <div><a href="{{ route('course.index', $group->id) }}">{{ $group->name }}</a></div>
                            <div><a
                                    href="{{ route('group.edit', $group->id) }}"> Редагувати</a></div>
                            @endforeach
                            @elseif(!isset($groups[0]))
                                <p class="noone-create-group">Ніхто ще не створював групи...</p>
                                <p class="noone-create-group">Нажміть <a class="here-point" onclick="displayList(document.getElementById('create-course-btn'));">сюди</a> щоб
                                    створити</p>
                        @endif
            </ul>
        </div>
        <div class="new-form none-displayed" id="course-form">
            <form id="course-list-form" method="POST" action="{{ route('course.store')}}">
                @csrf
                @php
                    $inputNames = array('name', 'group');
                @endphp
                <ul class="add-new-errors-list">
                    @foreach($inputNames as $name)
                        @error($name)
                        <li>
                            <span class="error-message">{{ $message }}</span>
                        </li>
                        @enderror
                    @endforeach
                </ul>
                <label>Назва</label>
                <input minlength="3" maxlength="100" required name="name" type="text">
                <label>Група</label>
                <select name="group">
                    @foreach ($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                    @endforeach
                </select>
                <button class="btn" type="submit">Додати</button>
            </form>
            <ul class="none-displayed" id="course-list">
                @if(isset($courses[0]))
                    @foreach($courses as $course)
                        <li>
                            <div><a href="{{ route('task.index', $course->id) }}">{{ $course->name }}</a></div>
                            <div><a
                                    href="{{ route('course.edit', $course->id) }}"> Редагувати</a></div>
                        </li>
                    @endforeach
                @elseif(!isset($courses[0]))
                    <p class="noone-create-group">Ви ще не створювали курси...
                    </p>
                    <p class="noone-create-group">Нажміть <a class="here-point" onclick="displayList(document.getElementById('create-course-btn'));">сюди</a> щоб створити</p>
                @endif
            </ul>

        </div>
        <div class="new-form none-displayed" id="task-form">
            <form id="task-list-form" enctype="multipart/form-data" method="POST" action="{{ route('task.store')}}">
                @php
                    $inputNames = array('course', 'topic','title','type','max_rating','message','file');
                @endphp
                <ul class="add-new-errors-list">
                    @foreach($inputNames as $name)
                        @error($name)
                        <li>
                            <span class="error-message">{{ $message }}</span>
                        </li>
                        @enderror
                    @endforeach
                </ul>
                @csrf
                <label>Курси</label>
                <select required name="course">
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                    @endforeach
                </select>
                <label>Теми</label>
                <input minlength="3" maxlength="100" required name="topic" list="topic">
                <datalist id="topic">
                    @foreach ($topics as $topic)
                        <option value="{{$topic->topic}}">
                    @endforeach
                </datalist>
                <label>Назва</label>
                <input minlength="3" maxlength="100" required name="title" type="text">
                <label>Тип</label>
                <select required name="type">
                    <option value="practice">practice</option>
                    <option value="theory">theory</option>
                    <option value="advertisement">advertisement</option>
                </select>
                <label>Максимальний бал</label>
                <input min="1" max="1000" required name="max_rating" type="number">
                <label>Опис завдання</label>
                <textarea minlength="3" maxlength="2000" name="message" required></textarea>
                <label>Файл</label>
                <div class="drop-zone create-task-drop-input">
                    <span class="drop-zone__prompt">Drop file here or click to upload(zip, rar)</span>
                    <input accept=".zip, .rar" type="file" name="file" class="drop-zone__input">
                </div>
                <button class="btn" type="submit">Додати</button>
            </form>
            <ul class="none-displayed" id="task-list">
                @if(isset($tasks[0]))
                    @foreach($tasks as $task)
                        <li>
                            <div><a href="{{ route('task.show', $task->id) }}">{{ $task->title }}</a></div>
                            <div><a
                                    href="{{ route('task.edit', $task->id) }}"> Редагувати</a></div>
                        </li>
                    @endforeach
                @elseif(!isset($tasks[0]))
                    <p class="noone-create-group">Ви ще не створювали завдань ...</p>
                    <p class="noone-create-group">Нажміть <a class="here-point" onclick="displayList(document.getElementById('create-course-btn'));">сюди </a>щоб створити</p>
                @endif
            </ul>
            <script src="{{ url('js/new-btn.js') }}"></script>
        </div>
    </div>
    <script src="{{ url('js/drag-and-drop.js') }}"></script>
@endsection
