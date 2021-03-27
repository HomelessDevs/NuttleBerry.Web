@extends('templates.form-template')
@section('content')
<p class="text-to-verify nuttleberry-text">Щоб продовжити підтвердіть вашу електронну адресу</p>
@if(session('status'))
    <p class="text-to-verify status-span-message">{{ session('status') }}</p>
    @endif
    <form method="post" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn resend-btn" type="submit"  name="login">Відправити ще раз</button>
    </form>
@endsection
