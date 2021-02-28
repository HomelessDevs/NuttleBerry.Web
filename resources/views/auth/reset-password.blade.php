@extends('templates.main-template')
@section('content')
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        <label>
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
        </label>
        <label>
            <input type="email" name="email" value="{{ $request->email }}">
        </label>
        <label>
            <input required type="text" name="password">
        </label>
        @error('password')
        <strong>{{ $message }}</strong>
        @enderror
        <label>
            <input required type="text" name="password_confirmation">
        </label>
        <input name="reset" value="Update" type="submit">

    </form>
@endsection
