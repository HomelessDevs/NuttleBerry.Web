@extends('templates.form-template')
@section('content')
    <h1>Забув пароль</h1>
    <form class="simple-form" method="post" action="{{ route('password.request') }}">
        @csrf

        <div>
            <label>email</label>
            <input type="email" name="email">
        </div>
        @if(session('status'))
            <span class="status-span-message">{{ session('status') }}</span>
        @endif
        @error('email')
        <span class="error-message">{{ $message }}</span>
        @enderror
        <div>
            <button name="reset" type="submit">Скинути</button>
        </div>
    </form>
@endsection
