<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The users connections model
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereSender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereUpdatedAt($value)
 *
 * @property string $id
 * @property array $users
 * @property string $sender
 * @property string $status
 */
class Connection extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['users', 'sender', 'status'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'users' => 'json',
    ];

    /**
     * Get the ID of the connection.
     *
     * @return string
     */
    public function getID(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Set the users for the connection.
     *
     * @param mixed $users
     * @return void
     */
    public function setUsers(mixed $users): void
    {
        $this->attributes['users'] = json_encode($users);
    }

    /**
     * Get the users of the connection.
     *
     * @return mixed
     */
    public function getUsers(): mixed
    {
        return json_decode($this->attributes['users'], true);
    }
    
    /**
     * Set the sender for the connection.
     *
     * @param string $sender
     * @return void
     */
    public function setSender(string $sender): void
    {
        $this->attributes['sender'] = trim($sender);
    }

    /**
     * Get the sender of the connection.
     *
     * @return string
     */
    public function getSender(): string
    {
        return $this->attributes['sender'];
    }

    /**
     * Set the status for the connection.
     *
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->attributes['status'] = trim($status);
    }

    /**
     * Get the status of the connection.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }
}
