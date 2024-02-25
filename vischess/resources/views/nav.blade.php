<div class="container">
    <nav class="nav" id="test">
        <a class="navOptions" href="{{ url('/') }}">Home</a>
        <a class="navOptions" href="{{ url('games') }}">Games</a>
        @auth
        <a class="navOptions" href="{{ url('favorites') }}">Favorites</a>
        @endauth
        <a class="navOptions" href="{{ url('studies') }}">Studies</a>
        <a class="navOptions" href="{{ url('analysis') }}">Analysis</a>
        <a class="navOptions" href="{{ url('about') }}">About</a>


        <div class="register">
            @guest
            <a class="navOptions login register" href="{{ url('register') }}">Register</a>
            <a class="navOptions login" href="{{ url('login') }}">Login</a>
            @else
            <div class="login">
                <form method="POST" action="{{ url('logout') }}">
                    @csrf
                    <button class="logout">Log Out</button>
                </form>
            </div>
            @endguest
        </div>

    </nav>