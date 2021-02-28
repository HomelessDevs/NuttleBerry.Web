@extends('templates.main-template')
@section('content')
    <h1>Groups</h1>
        <ul>
            @foreach($groups as $group)
                <li><a href="{{ route('course.index', $group->id) }}">{{ $group->name }}</a>
                </li>
            @endforeach
        </ul>
@endsection
