<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    protected $fillable = ['users', 'sender', 'status'];

    protected $casts = [
        'users' => 'json',
    ];

    public function getID(): string
    {
        return $this->attributes['id'];
    }

    public function setUsers(mixed $users): void
    {
        $this->attributes['users'] = json_encode($users);
    }

    public function getUsers(): mixed
    {
        return json_decode($this->attributes['users'], true);
    }
    
    public function setSender(string $sender): void
    {
        $this->attributes['sender'] = trim($sender);
    }

    public function getSender(): string
    {
        return $this->attributes['sender'];
    }

    public function setStatus(string $status): void
    {
        $this->attributes['status'] = trim($status);
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }
}
