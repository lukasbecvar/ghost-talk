<nav class="navbar">
    <div class="navbar-left">
        <a href="/">Home</a>
        <a class="navbar-link" href="/about">About</a>  
    </div>
    <div class="navbar-right">
        @if ($is_loggedin)
            <span class="m-r-3">{{$username}}</span>
            <span class="m-r-3">|</span>
            <a href="/logout">Logout</a>
        @else
            <a href="/login">Login</a>
        @endif
    </div>
</nav>
