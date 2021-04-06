@extends('templates.form-template')
@section('content')
    <form class="simple-form" enctype="multipart/form-data" method="POST" action="{{ route('task.update', $task->id)}}">
        {{ method_field('PUT') }}
        @csrf
        <div>
            <label>Курс</label>
            <select required name="course">
                @foreach ($courses as $course)
                    <option @if($task->course_id == $course->id) selected
                            @endif value="{{$course->id}}">{{$course->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>Теми</label>
            <input minlength="3" maxlength="100" required value="{{ $task->topic }}" name="topic" list="topic">
            <datalist id="topic">
                @foreach ($topics as $topic)
                    <option value="{{$topic->topic}}">
                @endforeach
            </datalist>
        </div>
        <div>
            <label>Назва</label>
            <input minlength="3" maxlength="100" value="{{ $task->title }}" required name="title" type="text">
        </div>
        <div>
            <label>Максимальний бал</label>
            <input max="1000" value="{{ $task->max_rating }}" required name="max_rating" type="number" min="1">
        </div>
        <div>
            <label>Опис завдання</label>
            <textarea minlength="3" maxlength="2000" required name="message" type="text">{{ $task->description }}</textarea>
        </div>
        <label>Файл</label>
        <div class="drop-zone create-task-drop-input">
            <span class="drop-zone__prompt">Опустіть файл сюди або натисніть, щоб завантажити</span>
            <input type="file" name="file" class="drop-zone__input">
        </div>
        <div>
            <label>Термін здачі</label>
            <input name="deadline" type="date">
        </div>
        <div>
            <button type="submit">Редагувати</button>
        </div>
    </form>
    <form class="simple-form" method="POST" action="{{ route('task.destroy', $task->id)}}">
        @csrf
        {{ method_field('DELETE') }}
        <div>
            <button onclick="return confirm('Ви впевнені що хочете видалити завдання разом з виконаними роботами ?')" class="destroy-btn" type="submit">Видалити</button>
        </div>
    </form>
    @foreach ($errors->all() as $error)
        <li><p class="error-text">{{ $error }}</p></li>
    @endforeach
    <script src="{{ url('js/drag-and-drop.js') }}"></script>

@endsection
