@extends('templates.main-template')
@section('content')

    @if($user == null)
        <div><p>User not found</p></div>
    @else
        <div class="profile-title">
            <h1>Профіль</h1>
        </div>
        <div class="main-profile-block">
            <div class="profile-photo">
                <img src="@if($user->photo != "none"){{ asset("storage/$user->photo") }}@else{{ asset("storage/profile-picture.png") }}@endif">
            </div>
            <div class="profile-info">
                <div>
                    <div class="profile-name">
                        <p>{{$user->name}}</p>
                    </div>
                    <div class="profile-role">
                        <p>{{$user->role}}</p>
                    </div>
                </div>
                @if($user->id == Auth::user()->id)
                    <div class="profile-edit">
                        <a href="{{route('profile.edit', $user->id)}}">Редагувати</a>
                    </div>
                @endif
                @if(Auth::user()->role == "teacher"  || Auth::user()->role == "admin")
                    @if( $user->role != 'admin' && $user->role != 'teacher' )
                        <form method="POST" action="'. route('profile.promote', $user->id) .'">
                            {{method_field('PUT')}}
                            @csrf
                            <input type="submit" value="promote to teacher">
                        </form>
                    @endif
                @endif
                <div class="profile-logout">
                    <br>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Вийти
                    </a>
                </div>
            </div>
        </div>
        <div class="my-courses-profile">
        <h2>Мої курси</h2>
        </div>
        <ul class="standard-list">
            @foreach($courses as $course)
                <li>
                    <a href="{{ route('task.index', $course->id) }}">{{ $course->name }}</a>
                </li>
            @endforeach
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
        </form>
    @endif
@endsection
