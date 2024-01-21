# Ghost Talk
The lightweight, anonymous chat application based on Laravel php framework

## About ghost talk
The main focus is on the anonymous and lightweight chat application with basic chat (only text) function with minimal javascript and without logging anything on host server.

## Main usage
The main usage of this application is usage under onion network for people in censored countries. 
I would like to set higher standard and quality of anonymous chat applications as opposed to similar "shit coded solutions"

## Javascript in ghost talk
For the main chat component it is necessary to allow javascript background function to get and send messages without having to refresh the page all the time.
I will focus on minimizing the amount of javascript code in the background and avoiding the execution of malicious code using XSS.

## Logging in ghost talk
The ghost talk has no functions for logging ip address or other values like geolocation etc.

## Account system (password reset)
For the maximum anonymity it will be impossible to use any type of email address authentication, login and registration will be only with username and password. It will never be possible to reset passwords!

## TODO
- [X] Setup and clean laravel
- [X] Basic app base
- [ ] Basic layout & style system (only for development)
- [ ] Home component with information about project
- [ ] Auth system
- [ ] Basic user panel (username, basic navigation(logout link))
- [ ] Contact list (store contacts(users))
- [ ] User search (add to contacts(with verification))
- [ ] Pending users list (contact list component)
- [ ] User settings (change password, deactivate account, delete all chats)
- [ ] Chat list component
- [ ] Main chat component with
- [ ] Highlight url links in messages
- [ ] Photo & video share in chat
- [ ] File share in chat

## Dependencies 
* Laravel
   * [Website](https://laravel.com/)
* PHPunit
   * [Website](https://phpunit.de/)
   