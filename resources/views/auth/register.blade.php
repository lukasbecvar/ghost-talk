@extends('base.main-base')

@section('content')
    <h1>register</h1>

    @if ($error_msg)
        <p>
            error: {{ $error_msg }}
        </p>
    @endif

    <form action="/register" method="post">
        
        @csrf
        <input type="text" name="username" placeholder="Username" value={{ $username }}>
        <input type="password" name="password" placeholder="Password" value={{ $password }}>
        <input type="password" name="re-password" placeholder="Password again" value={{ $re_password }}>

        <button type="submit" name="register-submit">Register</button>
    </form>
@endsection
