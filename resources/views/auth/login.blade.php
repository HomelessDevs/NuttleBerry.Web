@extends('templates.form-template')
@section('content')
    <h1>Логін</h1>
    <form class="simple-form" method="post" action="{{ route('login') }}">
        @csrf
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
        <div class="forgot-register"><a class="forgot-password" href="{{ route('password.request') }}">Забув пароль</a><a href="{{ route('register') }}">Реєстрація</a></div>
        <div>
            <button type="submit">Ввійти</button>
        </div>
    </form>
@endsection
