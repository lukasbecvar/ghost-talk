@extends('base.main-base')

@section('content')
<div class="chat-component">
    <div class="chat-list">
        <ul>
            <div class="contact-list-navbar">
                <a href="#">Search contacts</a>
            </div>



            <li><a href="#">Jan</a></li>
            <li><a href="#">Pepa</a></li>



        </ul>
    </div>
    <div class="chat-box">
        <div class="message-container">



            <div class="message incoming">
                <div class="title">
                    <span class="username">User1</span>
                    <span class="timestamp">12:30</span>
                </div>
                Incoming message 1
            </div>

            <div class="message outgoing">
                <div class="title">
                    <span class="username">You</span>
                    <span class="timestamp">12:30</span>
                </div>
                Outgoing message 1
            </div>



        </div>
        <div class="message-input-container">
            <input type="text" class="message-input" placeholder="Type your message">
            <button class="send-button">Send</button>
        </div>
    </div>
</div>
@endsection
