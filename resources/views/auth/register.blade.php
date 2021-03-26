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
            @error('email')
            <strong>{{ $message }}</strong>
            @enderror
        </div>
        <div>
            <label>Пароль</label>

            <input required type="password" name="password">
            @error('password')
            <strong>{{ $message }}</strong>
            @enderror
        </div>
        <div>
            <label>Повторіть пароль</label>
            <input required type="password" name="password_confirmation">
        </div>
        <div>
            <button type="submit">Зареєструватися</button>
        </div>
    </form>
@endsection
