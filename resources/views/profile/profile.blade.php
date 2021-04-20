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

                    @if($user->photo != "none")<img src="{{ "https://drive.google.com/uc?export=view&id=$photo" }}">
                @elseif($user->photo == "none")
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:#606161;}</style></defs><title/><g data-name="Layer 7" id="Layer_7"><path class="cls-1" d="M19.75,15.67a6,6,0,1,0-7.51,0A11,11,0,0,0,5,26v1H27V26A11,11,0,0,0,19.75,15.67ZM12,11a4,4,0,1,1,4,4A4,4,0,0,1,12,11ZM7.06,25a9,9,0,0,1,17.89,0Z"/></g></svg>
                @endif
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
