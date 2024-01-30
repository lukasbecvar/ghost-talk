<?php

namespace App\Managers;

use App\Models\Message;

class ChatManager
{
    public function getMessages(string $chat_id): object
    {
        return Message::where('chat_id', $chat_id)->get();
    }
}
