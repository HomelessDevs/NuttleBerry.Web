@extends('templates.form-template')
@section('content')
    <form enctype="multipart/form-data" class="simple-form" method="POST" action="{{ route('profile.update', Auth::user()->id) }}">
        {{ method_field('PUT') }}
        @csrf
        <div>
            <label>Ім'я </label>
            <input value="{{Auth::user()->name}}" name="name" type="text">
            <label>Фото</label>
            <div class="drop-zone create-task-drop-input">
                <span class="drop-zone__prompt">Опустіть файл сюди або натисніть, щоб завантажити</span>
                <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg" class="drop-zone__input">
            </div>
        </div>
        <div>
            <button type="submit">Змінити</button>
        </div>
    </form>
    <script src="{{ url('js/drag-and-drop.js') }}"></script>

@endsection
