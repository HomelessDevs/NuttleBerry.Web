<header>
    <div class="header-wrap">
        <nav class="header-navigation">
            <div id="hamburger" class="hamburger-menu">
                <div class="stick"></div>
                <div class="stick"></div>
                <div class="stick"></div>
            </div>
            <ul id="nav-menu">
                <li><a href="{{ route('group.index') }}">Групи</a></li>

                <li><a href="{{ route('course.myCourses') }}">Мої
                        курси</a>@if(Auth::check())
                        @if(Auth::user()->role == 'teacher' || Auth::user()->role == 'admin')
                            @if($count != 0)
                        <div
                            class="circle-count">{{ $count }}</div>
                                @endif
                    @endif
                    @endif

                </li>
                @if(Auth::check())
                    @if(Auth::user()->role == "teacher" || Auth::user()->role == "admin")
                        <li><a href="{{ route('administrating') }}">Адміністрування</a></li>
                    @endif
                @endif
            </ul>
        </nav>
        @if (Route::has('login'))
            <nav class="login">
                <ul>
                    @auth
                        <li><a href="{{ route('profile.show',  Auth::user()->id) }}">Профіль</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Логін</a></li>
                        @if (Route::has('register'))

                            <li><a href="{{ route('register') }}">Реєстрація</a></li>
                        @endif
                    @endauth
                </ul>
            </nav>
        @endif
    </div>
</header>
