@extends('base.main-base')

@section('content')
<center>
    <div class="component">
        <div class="form-container">
            <h1 class="form-title">Search contact</h1>
            
            @if ($error_msg)            
                @include('sub-components.error-message-box')
            @endif

            <form action="/contact/search" method="post" autocomplete="off">
                @csrf
                <input type="text" name="username" placeholder="Username" value="{{ $username_input }}" class="form-input" autocomplete="off">
                <button type="submit" name="contact-search-submit" class="form-button">Search</button>
            </form>
        </div>
    </div>
</center>
@endsection
