@extends('base.main-base')

@section('content')
<center>
    <div class="component">
        <div class="profile-box">
            <div class="profile-info">
                <span class="label">Username:</span>
                <span class="value">{{ $user_data->username }}</span>
            </div>
            <div class="profile-info">
                @php
                    $lowercaseRole = strtolower($user_data->role);
                @endphp
                <span class="label">Role:</span>
                <span class="value 
                    @if($lowercaseRole === 'user') green-text 
                    @elseif($lowercaseRole === 'vip') gold-text 
                    @elseif(in_array($lowercaseRole, ['admin', 'owner'])) red-text 
                    @else black-text @endif">{{ $user_data->role }}
                </span>
            </div>
            <div class="profile-info">
                <span class="label">Status:</span>
                <span class="value">{{ $user_data->status }}</span>
            </div>
            <div class="profile-info">
                <span class="label">Registered Date:</span>
                <span class="value">{{ $user_data->created_at }}</span>
            </div>
            @if ($username != $user_data->username)
                @if ($connection_status == 'pending')
                    <button class="add-to-contact-btn waiting">Waiting...</button>
                @elseif ($connection_status == 'active')
                    <button class="add-to-contact-btn waiting">Connected</button>
                    <a href="/contact/delete?name={{$user_data->username}}" class="add-to-contact-btn block-contact-btn">Delete</a>
                @else
                    <a href="/contact/add?name={{$user_data->username}}" class="add-to-contact-btn">Add to Contact</a>
                @endif


            @endif
        </div>
    </div>
</center>
@endsection
