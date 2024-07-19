# Ghost Talk
The lightweight, anonymous chat application based on Laravel php framework

## About
The main focus is on the anonymous and lightweight chat application with basic chat (only text) function with minimal javascript and without logging anything on host server.

## Primary use
The main usage of this application is usage under onion network for people in censored countries. 
I would like to set higher standard and quality of anonymous chat applications as opposed to similar "shit coded solutions"

## Javascript
For the main chat component it is necessary to allow javascript background function to get and send messages without having to refresh the page all the time.
I will focus on minimizing the amount of javascript code in the background and avoiding the execution of malicious code using XSS.

## Cookie & session
For the maximum anonymity ghost talk not using any cookies, and have own session util system for best controll to store session, session is used only for authentification (only one value is stored in session: user-token for identification current running session)

## Logging
The ghost talk has no functions for logging ip address or other values like geolocation etc.

## Account system (password reset)
For the maximum anonymity it will be impossible to use any type of email address authentication, login and registration will be only with username and password. It will never be possible to reset passwords!

## Dependencies 
* Laravel
   * [Website](https://laravel.com/)
   
## License
The framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
