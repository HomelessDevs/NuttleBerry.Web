@extends('templates.form-template')
@section('content')
    <h1>Реєстрація</h1>
    <form class="simple-form" method="post" action="{{ route('register') }}">
        @csrf
        <div>
            <label>Ім'я</label>
            <input required type="text" name="name">
        </div>
        <div>
            <label>Прізвище</label>
            <input required type="text" name="surname">
        </div>
        <div>
            <label>Е-мейл</label>

            <input required type="email" name="email">

        </div>
        <div>
            <label>Пароль</label>

            <input min="8" required type="password" name="password">

        </div>
        <div>
            <label>Повторіть пароль</label>
            <input min="8" required type="password" name="password_confirmation">
        </div>
        @php
            $inputNames = array('password','email','password_confirmation','surname','name');
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
            <button type="submit">Зареєструватися</button>
        </div>
    </form>
@endsection
