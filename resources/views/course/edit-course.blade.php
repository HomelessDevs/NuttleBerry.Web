@extends('templates.main-template')
@section('content')
    <form method="POST" action="{{ route('course.update', $course->id)}}">
        {{ method_field('PUT') }}
        @csrf
        <label>name
            <input value="{{ $course->name }}" name="name" type="text">
        </label>
        <label>group
            <select name="group">
                @foreach ($groups as $group)
                    <option @if($course->group_id == $group->id) selected
                            @endif value="{{$group->name}}">{{$group->name}}</option>
                @endforeach
            </select>
        </label>
        <input type="submit">
    </form>
@endsection

