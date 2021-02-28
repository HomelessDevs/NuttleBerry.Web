@extends('templates.main-template')
@section('content')
    <h1>register</h1>
    <form method="post" action="{{ route('register') }}">
        @csrf
        <label>
            <input required type="text" name="name">
        </label>
        <label>
            <input required type="email" name="email">
        </label>
        @error('email')
        <strong>{{ $message }}</strong>
        @enderror
        <label>
            <input required type="text" name="password">
        </label>
        @error('password')
        <strong>{{ $message }}</strong>
        @enderror
        <label>
            <input required type="text" name="password_confirmation">
        </label>
        <input type="submit">
    </form>
@endsection
