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

    public function setUsers(mixed $value): void
    {
        $this->attributes['users'] = json_encode($value);
    }

    public function getUsers(): mixed
    {
        return json_decode($this->attributes['users'], true);
    }
    
    public function setSender(string $value): void
    {
        $this->attributes['sender'] = trim($value);
    }

    public function getSender(): string
    {
        return $this->attributes['sender'];
    }

    public function setStatus(string $value): void
    {
        $this->attributes['status'] = trim($value);
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }
}
