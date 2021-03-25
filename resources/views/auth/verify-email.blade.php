@extends('templates.form-template')
@section('content')
<p class="text-to-verify">To continue pls verify your email</p>
@if(session('status'))
    <p lass="text-to-verify">{{ session('status') }}</p>
    @endif
    <form method="post" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn resend-btn" type="submit"  name="login">Відправити ще раз</button>
    </form>
@endsection
