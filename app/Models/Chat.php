<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['users', 'status'];

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
    
    public function setStatus(string $value): void
    {
        $this->attributes['status'] = trim($value);
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }
}
