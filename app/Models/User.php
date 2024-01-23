<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['username', 'password', 'token', 'status'];

    public function getID(): string
    {
        return $this->attributes['id'];
    }

    public function getUsername(): string
    {
        return $this->attributes['username'];
    }

    public function setUsername(string $username)
    {
        $this->attributes['username'] = $username;
    }

    public function getPassword(): string
    {
        return $this->attributes['password'];
    }

    public function setPassword(string $password)
    {
        $this->attributes['password'] = $password;
    }

    public function getToken(): string
    {
        return $this->attributes['token'];
    }

    public function setToken(string $token)
    {
        $this->attributes['token'] = $token;
    }

    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    public function setStatus(string $status)
    {
        $this->attributes['status'] = $status;
    }
}
