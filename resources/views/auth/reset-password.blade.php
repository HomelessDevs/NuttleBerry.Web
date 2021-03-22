@extends('templates.form-template')
@section('content')
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div>
            <label>Е-мейл</label>
            <input type="email" name="email" value="{{ $request->email }}">
        </div>
        <div>
            <label>Пароль</label>
            <input required type="text" name="password">
            @error('password')
            <strong>{{ $message }}</strong>
            @enderror
        </div>
        <div>
            <label>Повторіть пароль</label>
            <input required type="text" name="password_confirmation">
        </div>
        <div>
            <button name="reset" type="submit">Оновити</button>
        </div>
    </form>
@endsection
