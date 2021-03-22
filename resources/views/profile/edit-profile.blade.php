@extends('templates.form-template')
@section('content')
    <form enctype="multipart/form-data" class="simple-form" method="POST" action="{{ route('profile.update', Auth::user()->id) }}">
        {{ method_field('PUT') }}
        @csrf
        <div>
            <label>Ім'я </label>
            <input value="{{Auth::user()->name}}" name="name" type="text">
            <input type="file" name="photo" accept="image/jpeg,image/png,image/jpg">
        </div>
        <div>
            <button type="submit">Змінити</button>
        </div>
    </form>
@endsection
