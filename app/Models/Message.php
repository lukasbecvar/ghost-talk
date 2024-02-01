<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The database chat message model 
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 *
 * @property string $id
 * @property string $message
 * @property string $sender
 * @property string $chat_id
 */
class Message extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['message', 'sender', 'chat_id'];

    /**
     * Get the ID of the message.
     *
     * @return string
     */
    public function getID(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the message content.
     *
     * @return string
     */
    public function getMessage(): string
    {
        return $this->attributes['message'];
    }

    /**
     * Set the message content.
     *
     * @param string $message
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->attributes['message'] = $message;
    }

    /**
     * Get the sender of the message.
     *
     * @return string
     */
    public function getSender(): string
    {
        return $this->attributes['sender'];
    }

    /**
     * Set the sender of the message.
     *
     * @param string $sender
     * @return void
     */
    public function setSender(string $sender): void
    {
        $this->attributes['sender'] = $sender;
    }

    /**
     * Get the chat ID associated with the message.
     *
     * @return string
     */
    public function getChatID(): string
    {
        return $this->attributes['chat_id'];
    }

    /**
     * Set the chat ID associated with the message.
     *
     * @param string $chat_id
     * @return void
     */
    public function setChatID(string $chat_id): void
    {
        $this->attributes['chat_id'] = $chat_id;
    }
}
