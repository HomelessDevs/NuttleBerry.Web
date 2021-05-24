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
                            <div><a class="svg-a-edit"
                                    href="{{ route('group.edit', $group->id) }}"> <svg xmlns="http://www.w3.org/2000/svg" height="512pt" viewBox="0 0 512 511" width="512pt">
                                        <path
                                            d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/>
                                        <path
                                            d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/>
                                        <path
                                            d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/>
                                    </svg></a></div>
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
                            <div><a class="svg-a-edit"
                                    href="{{ route('course.edit', $course->id) }}"> <svg xmlns="http://www.w3.org/2000/svg" height="512pt" viewBox="0 0 512 511" width="512pt">
                                        <path
                                            d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/>
                                        <path
                                            d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/>
                                        <path
                                            d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/>
                                    </svg></a></div>
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
                    $inputNames = array('deadline', 'course', 'topic','title','type','max_rating','message','file');
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
                <label>Курс</label>
                <select required name="course">
                    @foreach ($courses as $course)
                        <option value="{{$course->id}}">{{$course->name}}</option>
                    @endforeach
                </select>
                <label>Назва</label>
                <input minlength="3" maxlength="100" required name="title" type="text">
                <label>Тема</label>
                <input minlength="3" maxlength="100" required name="topic" list="topic">
                <datalist id="topic">
                    @foreach ($topics as $topic)
                        <option value="{{$topic->topic}}">
                    @endforeach
                </datalist>

                <label>Тип</label>
                <select required name="type">
                    <option value="practice">Практика</option>
                    <option value="theory">Теорія</option>
                </select>
                <label>Опис завдання</label>
                <textarea minlength="3" maxlength="2000" name="message" required></textarea>
                <label>Максимальний бал</label>
                <input min="1" max="1000" required name="max_rating" type="number">
                <label>Файл</label>
                <div class="drop-zone create-task-drop-input">
                    <span class="drop-zone__prompt">Перенесіть сюди файл або натисніть, щоб завантажити (zip, rar)</span>
                    <input accept=".zip, .rar" type="file" name="file" class="drop-zone__input">
                </div>
                <label>Термін здачі</label>
                <input name="deadline_date" type="date">
                <input name="deadline_time" type="time">
               <button class="btn" type="submit">Додати</button>
            </form>
            <ul class="none-displayed" id="task-list">
                @if(isset($tasks[0]))
                    @foreach($tasks as $task)
                        <li>
                            <div><a href="{{ route('task.show', $task->id) }}">{{ $task->title }}</a></div>
                            <div><a class="svg-a-edit"
                                    href="{{ route('task.edit', $task->id) }}"> <svg xmlns="http://www.w3.org/2000/svg" height="512pt" viewBox="0 0 512 511" width="512pt">
                                        <path
                                            d="m405.332031 256.484375c-11.796875 0-21.332031 9.558594-21.332031 21.332031v170.667969c0 11.753906-9.558594 21.332031-21.332031 21.332031h-298.667969c-11.777344 0-21.332031-9.578125-21.332031-21.332031v-298.667969c0-11.753906 9.554687-21.332031 21.332031-21.332031h170.667969c11.796875 0 21.332031-9.558594 21.332031-21.332031 0-11.777344-9.535156-21.335938-21.332031-21.335938h-170.667969c-35.285156 0-64 28.714844-64 64v298.667969c0 35.285156 28.714844 64 64 64h298.667969c35.285156 0 64-28.714844 64-64v-170.667969c0-11.796875-9.539063-21.332031-21.335938-21.332031zm0 0"/>
                                        <path
                                            d="m200.019531 237.050781c-1.492187 1.492188-2.496093 3.390625-2.921875 5.4375l-15.082031 75.4375c-.703125 3.496094.40625 7.101563 2.921875 9.640625 2.027344 2.027344 4.757812 3.113282 7.554688 3.113282.679687 0 1.386718-.0625 2.089843-.210938l75.414063-15.082031c2.089844-.429688 3.988281-1.429688 5.460937-2.925781l168.789063-168.789063-75.414063-75.410156zm0 0"/>
                                        <path
                                            d="m496.382812 16.101562c-20.796874-20.800781-54.632812-20.800781-75.414062 0l-29.523438 29.523438 75.414063 75.414062 29.523437-29.527343c10.070313-10.046875 15.617188-23.445313 15.617188-37.695313s-5.546875-27.648437-15.617188-37.714844zm0 0"/>
                                    </svg></a></div>
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
