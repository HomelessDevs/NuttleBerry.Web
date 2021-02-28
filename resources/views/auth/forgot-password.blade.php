@extends('templates.main-template')
@section('content')
    <form method="post" action="{{ route('password.request') }}">
        @csrf
        @if(session('status'))
            {{ session('status') }}
            @endif
        <label>
            <input type="email" name="email">
            <input name="reset" type="submit">
        </label>
    </form>
@endsection
