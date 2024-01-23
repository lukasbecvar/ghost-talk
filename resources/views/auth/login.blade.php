@extends('base.main-base')

@section('content')
    <h1>login</h1>

    @if ($error_msg)
        <p>
            error: {{ $error_msg }}
        </p>
    @endif

    <form action="/login" method="post">
        
        @csrf
        <input type="text" name="username" placeholder="Username" value={{ $username }}>
        <input type="password" name="password" placeholder="Password" value={{ $password }}>

        <button type="submit" name="login-submit">Login</button>
    </form>
@endsection
