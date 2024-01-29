<div class="chat-list">
    <ul>
        <div class="contact-list-navbar">
            <a href="/contact/search">Search contacts</a>
            <a href="/pending/list">Pending [{{$pending_connections}}]</a>
        </div>
        @foreach ($connections as $connection)
            @php
                $users = $connection->getUsers();
                $otherUsername = ($users[0] !== $username) ? $users[0] : $users[1];
            @endphp
            
            @if ($connection->getStatus() === 'active')
                <li><a href="#">{{ $otherUsername }}</a></li>
            @endif
        @endforeach
    </ul>
</div>
