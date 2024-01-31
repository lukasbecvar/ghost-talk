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

            $chat_id = request('chat');

            if ($chat_id == null) {
                $this->errorManager->handleError('error chat (query string parameter) is null', 400);
            } 
            
            $chat_id = $this->securityUtil->escapeString($chat_id);
            
            $chat_messages = $this->chatManager->getMessages($chat_id);

            return json_encode($chat_messages);

        } else {
            return view('error/error-403');
        }
    }

    public function sendMessage(Request $request): mixed
    {
        if ($this->userManager->isLoggedin()) {

            $chat_id = request('chat');
            $sender = $this->userManager->getLoggedUsername();
    
            $message_input = $request->input('message');

            if (strlen($message_input) > 2050) {
                $this->errorManager->handleError('maximal message length is 2000 characters', 400);
            }

            $message_input = $this->securityUtil->encryptAes($message_input);

            try {
                // Assume you have a Message model
                $message = new Message();
    
    
                $message->setMessage($message_input);
                $message->setSender($sender);
                $message->setChatID($chat_id);
    
    
                $message->save();
        
                return response()->json(['message' => 'Message sent successfully']);
            } catch (\Exception $e) {
                // Log the error for debugging
                logger('Error sending message:'. $e->getMessage());
        
                // Return an error response
                return response()->json(['error' => 'Error sending message'], 500);
            }

        } else {
            return view ('error/error-403');
        }
    }
}
