<?php

namespace App\Managers;

use App\Models\Message;
use App\Utils\SecurityUtil;

/**
 * Class ChatManager
 *
 * Manager class for handling chat-related functionality.
 *
 * @package App\Managers
 */
class ChatManager
{
    /**
     * The SecurityUtil instance for handling security-related tasks.
     *
     * @var SecurityUtil
     */
    private SecurityUtil $securityUtil;

    /**
     * The ErrorManager instance for handling errors.
     *
     * @var ErrorManager
     */
    private ErrorManager $errorManager;

    /**
     * ChatManager constructor.
     *
     * @param SecurityUtil $securityUtil
     * @param ErrorManager $errorManager
     */
    public function __construct(SecurityUtil $securityUtil, ErrorManager $errorManager)
    {
        $this->securityUtil = $securityUtil;
        $this->errorManager = $errorManager;
    }

    /**
     * Get messages for a given chat ID.
     *
     * @param string $chat_id
     * @return mixed
     */
    public function getMessages(string $chat_id): mixed
    {
        $data = Message::where('chat_id', $chat_id)->get();
    
        $result = [];
    
        foreach ($data as $value) {
    
            $message = $this->securityUtil->decryptAes($value->message);
    
            $item = [
                'id' => $value->id,
                'message' => $message,
                'sender' => $value->sender,
                'chat_id' => $value->chat_id,
                'created_at' => $value->created_at,
                'updated_at' => $value->updated_at
            ];
    
            array_push($result, $item);
        }
    
        return $result;
    }

    /**
     * Save a new chat message.
     *
     * @param string $message_input
     * @param string $sender
     * @param string $chat_id
     * @return void
     */
    public function saveChatMessage(string $message_input, string $sender, string $chat_id): void
    {
        try {
            // init message modeů
            $message = new Message();

            // set message data
            $message->setMessage($message_input);
            $message->setSender($sender);
            $message->setChatID($chat_id);

            // insert new chat message
            $message->save();
    
        } catch (\Exception $e) {
            $this->errorManager->handleError('error to insert new message: '.$e->getMessage(), 500);
        }
    }
}
