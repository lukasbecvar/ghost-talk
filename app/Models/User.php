<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * The user database model
 * 
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 *
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $token
 * @property string $status
 * @property string $role
 */
class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['username', 'password', 'token', 'status', 'role'];

    /**
     * Get the ID of the user.
     *
     * @return string
     */
    public function getID(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the username of the user.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->attributes['username'];
    }

    /**
     * Set the username of the user.
     *
     * @param string $username
     * @return void
     */
    public function setUsername(string $username): void
    {
        $this->attributes['username'] = $username;
    }

    /**
     * Get the password of the user.
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->attributes['password'];
    }

    /**
     * Set the password of the user.
     *
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->attributes['password'] = $password;
    }

    /**
     * Get the token of the user.
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->attributes['token'];
    }

    /**
     * Set the token of the user.
     *
     * @param string $token
     * @return void
     */
    public function setToken(string $token): void
    {
        $this->attributes['token'] = $token;
    }

    /**
     * Get the status of the user.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    /**
     * Set the status of the user.
     *
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }

    /**
     * Get the role of the user.
     *
     * @return string
     */
    public function getRole(): string
    {
        return $this->attributes['role'];
    }

    /**
     * Set the role of the user.
     *
     * @param string $role
     * @return void
     */
    public function setRole(string $role): void
    {
        $this->attributes['role'] = $role;
    }
}
