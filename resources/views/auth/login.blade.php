@extends('templates.main-template')
@section('content')
    <h1>login</h1>
    <form method="post" action="{{ route('login') }}">
        @csrf
        <label>
            <input required type="email"  name="email">
        </label>
        @error('email')
        <strong>{{ $message }}</strong>
        @enderror
        <label>
            <input required type="password" name="password">
        </label>
        @error('password')
        <strong>{{ $message }}</strong>
        @enderror
        <input type="submit">
    </form>
@endsection
