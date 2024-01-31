<?php

namespace App\Managers;

use App\Models\Message;
use App\Utils\SecurityUtil;

class ChatManager
{
    private SecurityUtil $securityUtil;

    public function __construct(SecurityUtil $securityUtil)
    {
        $this->securityUtil = $securityUtil;
    }

    public function getMessages(string $chat_id)
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
}
