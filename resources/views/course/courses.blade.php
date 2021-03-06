@extends('templates.main-template')
@section('content')
    <h1>{{$groupName}}</h1>
    <ul class="standard-list">
        @foreach($courses as $course)
            <li>
                <a href="{{ route('task.index', $course->id) }}">{{ $course->name }}</a>
            </li>
        @endforeach
    </ul>
@endsection

