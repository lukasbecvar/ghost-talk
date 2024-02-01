<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Utils\SecurityUtil;
use Illuminate\Http\Request;
use App\Managers\UserManager;
use App\Managers\ChatManager;
use App\Managers\ErrorManager;

/**
 * Class ChatApiController
 *
 * Controller handling API requests related to the chat functionality.
 *
 * @package App\Http\Controllers
 */
class ChatApiController extends Controller
{
    /**
     * The UserManager instance for managing user-related operations.
     *
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * The ChatManager instance for handling chat-related operations.
     *
     * @var ChatManager
     */
    private ChatManager $chatManager;

    /**
     * The ErrorManager instance for handling errors.
     *
     * @var ErrorManager
     */
    private ErrorManager $errorManager;

    /**
     * The SecurityUtil instance for handling security-related tasks.
     *
     * @var SecurityUtil
     */
    private SecurityUtil $securityUtil;

    /**
     * ChatApiController constructor.
     *
     * @param UserManager $userManager
     * @param ChatManager $chatManager
     * @param ErrorManager $errorManager
     * @param SecurityUtil $securityUtil
     */
    public function __construct(UserManager $userManager, ChatManager $chatManager, ErrorManager $errorManager, SecurityUtil $securityUtil)
    {
        $this->userManager = $userManager;
        $this->chatManager = $chatManager;
        $this->errorManager = $errorManager;
        $this->securityUtil = $securityUtil;
    }

    /**
     * Get chat messages.
     *
     * @return mixed
     */
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

    /**
     * Send a chat message.
     *
     * @param Request $request
     * @return mixed
     */
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

            $this->chatManager->saveChatMessage($message_input, $sender, $chat_id);

            return json_encode(['message' => 'success']);
        } else {
            return view('error/error-403');
        }
    }
}
