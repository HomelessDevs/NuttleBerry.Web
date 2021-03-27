@extends('templates.form-template')
@section('content')
    <h1>Логін</h1>

    <form class="simple-form" method="post" action="{{ route('login') }}">
        @csrf
        <div>
            <label>Е-мейл</label>
            <input required type="email" name="email">

        </div>
        <div>
            <label>Пароль</label>
            <input required type="password" name="password">

        </div>
        @error('password')
        <span class="error-message">{{ $message }}</span>
        @enderror
        @error('email')
        <span class="error-message">{{ $message }}</span>
        @enderror
        <div class="forgot-register"><a class="forgot-password" href="{{ route('password.request') }}">Забув пароль</a><a href="{{ route('register') }}">Реєстрація</a></div>
        <div>
            <button type="submit">Ввійти</button>
        </div>
    </form>

@endsection
