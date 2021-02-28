@extends('templates.main-template')
@section('content')
    <form method="POST" action="{{ route('group.update', $group->id)}}">
        {{ method_field('PUT') }}
        @csrf
        <label>name
            <input value="{{ $group->name }}" name = "name" type="text">
        </label>
        <input type="submit">
    </form>

@endsection

