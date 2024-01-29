@extends('base.main-base')

@section('content')
<center>
    <p class="page-title">Pending contacts</p>
    @foreach ($data as $connection)
        @php
            $users = $connection->getUsers();
            $otherUsername = ($users[0] !== $username) ? $users[0] : $users[1];
        @endphp
        
        @if ($connection->getStatus() === 'pending' and $connection->getSender() != $username)
            <div class="pending-component">
                <div class="buttons-container">
                    <p class="username">Username: {{ $otherUsername }}</p>
                    <a href="/pending/accept?name={{ $otherUsername }}" class="accept">Accept</a>
                    <a href="/pending/deny?name={{ $otherUsername }}" class="deny">Deny</a>
                </div>
            </div>
        @endif
    @endforeach
</center>
@endsection
