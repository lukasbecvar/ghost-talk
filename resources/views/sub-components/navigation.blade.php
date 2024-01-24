@if ($is_loggedin)
    <nav class="navbar">
        <div class="navbar-left">
            <a href="/">Home</a>
        </div>
        <div class="navbar-right">
            <span class="m-r-3">{{$username}}</span>
            <span class="m-r-3">|</span>
            <a href="/logout">Logout</a>
        </div>
    </nav>
@else
    <nav class="navbar">
        <div class="navbar-left">
            <a href="/">Home</a>
            <a class="navbar-link" href="/about">About</a>        
        </div>
        <div class="navbar-right">
            <a href="/login">Login</a>
        </div>
    </nav>
@endif
