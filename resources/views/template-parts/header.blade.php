<header>
    <nav>
        <a href="{{ route('group.index') }}">Курси</a>
        @if(Auth::check())
            @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
                <a href="{{ route('administrating') }}">Створити курси</a>
            @endif
                <a href="{{ route('task.journal') }}">Журнал</a>
        @endif
        <a href="{{ route('course.myCourses') }}">Мої курси</a>
    </nav>
    @if (Route::has('login'))
        <div class="login">

            @auth
                <a  href="{{ route('profile.show',  Auth::user()->id) }}" >Профіль</a>
            @else
                <a  href="{{ route('login') }}">Логін</a>

                @if (Route::has('register'))
                    <a  href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif
</header>
