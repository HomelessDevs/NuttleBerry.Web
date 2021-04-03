@extends('templates.main-template')
@section('content')
    @if($user == null)
        <div><p>User not found</p></div>
    @else
        <div class="profile-title">
            <h1>Профіль</h1>
        </div>
        @if(session()->has('message'))
            <div class="message-success">
                <p>{{ session()->get('message') }}</p>
            </div>
        @endif
        <div class="main-profile-block">
            <div class="profile-photo">
                <img
                    src="@if($user->photo != "none"){{ "https://drive.google.com/uc?export=view&id=$photo" }}@elseif($user->photo == "none"){{ asset("storage/profile.png") }}@endif">
            </div>
            <div class="profile-info">
                <div>
                    <div class="profile-name">
                        <p><span>{{$user->surname}} {{$user->name}}</span></p>
                    </div>
                    <div class="profile-role">
                        <p><span>@if($user->role == "student")
                                    студент@elseif($user->role == "teacher" || $user->role == "admin")
                                    вчитель@endif</span></p>
                    </div>
                    @if(Auth::user()->role == "teacher" && Auth::user()->id != $user->id || Auth::user()->role == "admin" && Auth::user()->id != $user->id)
                        <div class="promote-block ">
                            @if( $user->role != 'admin' && $user->role != 'teacher' )
                                <form method="POST" action="{{route('profile.promote', $user->id)}}">
                                    {{method_field('PUT')}}
                                    @csrf
                                    <button class="btn" type="submit">Підвищити до вчителя</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>
                @if($user->id == Auth::user()->id)
                    <div class="profile-edit">
                        <a href="{{route('profile.edit', $user->id)}}">Редагувати</a>
                    </div>
                @endif

                @if($user->id == Auth::user()->id)
                    <div class="profile-logout">

                        <a class="exit-a" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Вийти
                        </a>
                    </div>
                @endif
            </div>

        </div>

        @if($user->id == Auth::user()->id)
            <div class="my-courses-profile">
                <h2>Мої курси</h2>
            </div>
            @include('template-parts.courses')
        @endif
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    @endif
@endsection
