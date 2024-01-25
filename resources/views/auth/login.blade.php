@extends('base.main-base')

@section('content')
    <div class="component">
        <div class="form-container">
            <h1 class="form-title">login</h1>
    
            <!-- error msg (only if error found) -->
            @if ($error_msg)
                <p class="error-message">
                    error: {{ $error_msg }}
                </p>
            @endif
    
            <!-- login form -->
            <form action="/login" method="post" autocomplete="off">
                @csrf
                <input type="text" name="username" placeholder="Username" value="{{ $username }}" class="form-input" autocomplete="off">
                <input type="password" name="password" placeholder="Password" value="{{ $password }}" class="form-input" autocomplete="off">
                <button type="submit" name="login-submit" class="form-button">Login</button>
            </form>

            <p class="registration-link">
                Don't have an account? <a href="/register">Register here</a>
            </p>
        </div>
    </div>
@endsection
