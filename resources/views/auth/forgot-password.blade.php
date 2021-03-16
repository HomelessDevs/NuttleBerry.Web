@extends('templates.main-template')
@section('content')
    <form class="simple-form" method="post" action="{{ route('password.request') }}">
        @csrf
        @if(session('status'))
            {{ session('status') }}
        @endif
        <div>
            <label>email</label>
            <input type="email" name="email">
        </div>
        <div>
            <button name="reset" type="submit">Скинути</button>
        </div>
    </form>
@endsection
