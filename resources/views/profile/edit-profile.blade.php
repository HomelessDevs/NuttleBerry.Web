@extends('templates.main-template')
@section('content')
    <form method="POST" action="{{ route('profile.update', Auth::user()->id) }}">
        {{ method_field('PUT') }}
        @csrf
        <label>name
            <input value="{{Auth::user()->name}}" name = "name" type="text">
        </label>
        <input type="submit">
    </form>
@endsection
