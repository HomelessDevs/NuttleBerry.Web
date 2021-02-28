@extends('templates.main-template')
@section('content')
    <h1>My courses</h1>
    @foreach($courses as $course)
        <li>
            <a href="{{ route('task.index', $course->id) }}">{{ $course->name }}</a>
        </li>
    @endforeach
@endsection
