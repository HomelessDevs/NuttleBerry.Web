@extends('templates.main-template')
@section('content')
    <h1>Групи</h1>
        <ul class="groups-list">
            @foreach($groups as $group)
                <li><a href="{{ route('course.index', $group->id) }}">{{ $group->name }}</a>
                </li>
            @endforeach
        </ul>
@endsection
