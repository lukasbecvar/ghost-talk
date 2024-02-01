<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Http\Controller;
use App\Utils\SecurityUtil;
use Illuminate\Http\Request;
use App\Managers\UserManager;
use App\Managers\ChatManager;
use App\Managers\ErrorManager;

class ChatApiController extends Controller
{
    private UserManager $userManager;
    private ChatManager $chatManager;
    private ErrorManager $errorManager;
    private SecurityUtil $securityUtil;

    public function __construct(UserManager $userManager, ChatManager $chatManager, ErrorManager $errorManager, SecurityUtil $securityUtil)
    {
        $this->userManager = $userManager;
        $this->chatManager = $chatManager;
        $this->errorManager = $errorManager;
        $this->securityUtil = $securityUtil;
    }

    public function getChatMessages(): mixed
    {
        if ($this->userManager->isLoggedin()) {

            // get chat id (query parameter)
            $chat_id = request('chat');

            // check if chat id is seteds
            if ($chat_id == null) {
                $this->errorManager->handleError('error chat (query string parameter) is null', 400);
            } 
            
            // escape chat id
            $chat_id = $this->securityUtil->escapeString($chat_id);
            
            // get chat messages
            $chat_messages = $this->chatManager->getMessages($chat_id);

            return json_encode($chat_messages);
        } else {
            return view('error/error-403');
        }
    }

    public function sendMessage(Request $request): mixed
    {
        if ($this->userManager->isLoggedin()) {

            // get chat id (query parameter)
            $chat_id = request('chat');

            // get message sender
            $sender = $this->userManager->getLoggedUsername();
    
            // get message
            $message_input = $request->input('message');

            // check maximal chat message length
            if (strlen($message_input) > 2050) {
                $this->errorManager->handleError('maximal message length is 2000 characters', 400);
            }

            // escape chat message
            $message_input = $this->securityUtil->encryptAes($message_input);

            try {
                // init message modeů
                $message = new Message();
    
                // set message data
                $message->setMessage($message_input);
                $message->setSender($sender);
                $message->setChatID($chat_id);
    
                // insert new chat message
                $message->save();
        
                return response()->json(['message' => 'Message sent successfully']);
            } catch (\Exception $e) {
                $this->errorManager->handleError('error to insert new message: '.$e->getMessage(), 500);
                return null;
            }
        } else {
            return view ('error/error-403');
        }
    }
}
