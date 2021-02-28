<header>
    <nav>
        <a href="{{ route('group.index') }}">Courses</a>
        @if(Auth::check())
            @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
                <a href="{{ route('administrating') }}">New Courses</a>
            @endif
            <a href="{{ route('profile.show', Auth::user()->id) }}">Profile</a>
                <a href="{{ route('task.journal') }}">Journal</a>
        @endif
        <a href="{{ route('course.myCourses') }}">My courses</a>
    </nav>
    @if (Route::has('login'))
        <div class="login">

            @auth
                <a  href="{{ route('profile.show',  Auth::user()->id) }}" >Profile</a>
            @else
                <a  href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a  href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
</header>
