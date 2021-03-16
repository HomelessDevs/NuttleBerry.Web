@extends('templates.main-template')
@section('content')
    <form class="simple-form" enctype="multipart/form-data" method="POST" action="{{ route('task.update', $task->id)}}">
        {{ method_field('PUT') }}
        @csrf
        <div>
            <label>Курс</label>
            <select name="course">
                @foreach ($courses as $course)
                    <option @if($task->course_id == $course->id) selected
                            @endif value="{{$course->id}}">{{$course->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Теми</label>
            <input value="{{ $task->topic }}" name="topic" list="topic">
            <datalist id="topic">
                @foreach ($topics as $topic)
                    <option value="{{$topic->topic}}">
                @endforeach
            </datalist>
        </div>
        <div>
            <label>Назва</label>
            <input value="{{ $task->title }}" required name="title" type="text">
        </div>
        <div>
            <label>Тип</label>
            <select name="type">
                <option @if($task->type == "practice") selected @endif value="practice">practice</option>
                <option @if($task->type== "theory") selected @endif value="theory">theory</option>
                <option @if($task->type == "advertisement") selected @endif value="advertisement">advertisement</option>
            </select>
        </div>
        <div>
            <label>Опис завдання</label>
            <textarea required name="message" type="text">{{ $task->description }}</textarea>
        </div>
        <label>Файл</label>
        <div class="drop-zone create-task-drop-input">
            <span class="drop-zone__prompt">Опустіть файл сюди або натисніть, щоб завантажити</span>
            <input type="file" name="file" class="drop-zone__input">
        </div>
        <div>
            <button type="submit">Редагувати</button>
        </div>
    </form>
    <script src="{{ url('js/drag-and-drop.js') }}"></script>

@endsection
