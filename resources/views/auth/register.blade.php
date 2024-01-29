@extends('base.main-base')

@section('content')
    <div class="component">
        <div class="form-container">
            <h1 class="form-title">registration</h1>
            
            @if ($error_msg)    
                @include('components.sub-components.error-message-box')
            @endif

            <!-- register form -->
            <form action="/register" method="post" autocomplete="off">
                @csrf
                <input type="text" name="username" placeholder="Username" value="{{ $username }}" class="form-input" autocomplete="off">
                <input type="password" name="password" placeholder="Password" value="{{ $password }}" class="form-input" autocomplete="off">
                <input type="password" name="re-password" placeholder="Password again" value="{{ $re_password }}" class="form-input" autocomplete="off">
                <button type="submit" name="register-submit" class="form-button">Register</button>
            </form>

            <p class="registration-link">
                You have an account? <a href="/login">Login here</a>
            </p>
        </div>
    </div>
@endsection
