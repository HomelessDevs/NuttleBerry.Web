@extends('templates.form-template')
@section('content')
    <form class="simple-form" method="POST" action="{{ route('group.update', $group->id)}}">
        {{ method_field('PUT') }}
        @csrf
        <div>
            <label>Назва</label>
            <input value="{{ $group->name }}" name="name" type="text">
        </div>
        <div>
            <button type="submit">Редагувати</button>
        </div>
    </form>

@endsection

