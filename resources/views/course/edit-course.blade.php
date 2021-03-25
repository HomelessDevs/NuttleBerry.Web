@extends('templates.form-template')
@section('content')
    <form class="simple-form" method="POST" action="{{ route('course.update', $course->id)}}">
        {{ method_field('PUT') }}
        @csrf
        <div>
        <label>Назва</label>
        <input value="{{ $course->name }}" name="name" type="text">
        </div>
        <div>
        <label>Група</label>
        <select name="group">
            @foreach ($groups as $group)
                <option @if($course->group_id == $group->id) selected
                        @endif value="{{$group->id}}">{{$group->name}}</option>
            @endforeach
        </select>
        </div>
        <div>
            <button type="submit">Редагувати</button>
        </div>
    </form>
    @foreach ($errors->all() as $error)
        <li><p class="error-text">{{ $error }}</p></li>
    @endforeach
@endsection

