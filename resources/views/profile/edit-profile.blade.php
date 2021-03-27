@extends('templates.form-template')
@section('content')
    <form enctype="multipart/form-data" class="simple-form" method="POST" action="{{ route('profile.update', Auth::user()->id) }}">
        {{ method_field('PUT') }}
        @csrf
        <div>
            <label>Ім'я </label>
            <input minlength="2" value="{{Auth::user()->name}}" name="name" type="text">
            <label>Прізвище </label>
            <input minlength="2" value="{{Auth::user()->surname}}" name="surname" type="text">
            <label>Фото</label>
            <div class="drop-zone create-task-drop-input">
                <span class="drop-zone__prompt">Опустіть файл сюди або натисніть, щоб завантажити</span>
                <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg" class="drop-zone__input">
            </div>
        </div>
        @php
            $inputNames = array('name','surname','photo');
        @endphp
        <ul>
            @foreach($inputNames as $name)
                @error($name)
                <li>
                    <span class="error-message">{{ $message }}</span>
                </li>
                @enderror
            @endforeach
        </ul>
        <div>
            <button type="submit">Змінити</button>
        </div>
    </form>
    <script src="{{ url('js/drag-and-drop.js') }}"></script>

@endsection
