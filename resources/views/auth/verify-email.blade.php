@extends('templates.main-template')
@section('content')
<p>To continue pls verify your email</p>
@if(session('status'))
    {{ session('status') }}
    @endif
    <form method="post" action="{{ route('verification.send') }}">
        @csrf
        <input type="submit" value="Resend" name="login">
    </form>
@endsection
