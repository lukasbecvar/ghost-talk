<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['message', 'sender', 'chat_id'];

    public function getID(): string
    {
        return $this->attributes['id'];
    }

    public function getMessage(): string
    {
        return $this->attributes['message'];
    }

    public function setMessage(string $message): void
    {
        $this->attributes['message'] = $message;
    }

    public function getSender(): string
    {
        return $this->attributes['sender'];
    }

    public function setSender(string $sender): void
    {
        $this->attributes['sender'] = $sender;
    }

    public function getChatID(): string
    {
        return $this->attributes['chat_id'];
    }

    public function setChatID(string $chat_id): void
    {
        $this->attributes['chat_id'] = $chat_id;
    }
}
