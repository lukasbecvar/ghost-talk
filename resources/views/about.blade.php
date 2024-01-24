@extends('base.main-base')

@section('content')
    <div class="component">
        <div class="article-card">
            <h2 class="article-title">About Ghost Talk</h2>
            <p class="article-content">
                Ghost Talk is the lightweight, anonymous chat application with main focus is on 
                the anonymous and lightweight chat application with basic chat (only text) 
                function with minimal javascript and without logging anything on host server.
                <br><br>
                The main usage of this application is usage under onion network for people in censored countries. 
                I would like to set higher standard and quality of anonymous chat applications as 
                opposed to similar "shit coded solutions"
                <br><br>
                For the main chat component it is necessary to allow javascript background function to get and send messages 
                without having to refresh the page all the time. 
                I will focus on minimizing the amount of 
                javascript code in the background and avoiding the execution of malicious code using XSS.
                <br><br>
                For the maximum anonymity ghost talk not using any cookies, 
                and have own session util system for best controll to store session, 
                session is used only for authentification 
                (only one value is stored in session: user-token for identification current running session)
                <br><br>
                The Ghost talk has no functions for logging ip address or other values like geolocation etc.
                <br><br>
                For the maximum anonymity it will be impossible to use any type of email address authentication, 
                login and registration will be only with username and password. It will never be possible to reset passwords!
                <br><br>
                You can found ghost talk source on <a href="https://github.com/lordbecvold/ghost-talk" target="_blank" class="link">github</a>
            </p>
        </div>
    </div>
@endsection
