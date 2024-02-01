<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * The database log model
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereUpdatedAt($value)
 *
 * @property string $id
 * @property string $name
 * @property string $value
 * @property string $status
 */
class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name', 'value', 'status'];

    /**
     * Get the ID of the log.
     *
     * @return string
     */
    public function getID(): string
    {
        return $this->attributes['id'];
    }

    /**
     * Get the name of the log.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->attributes['name'];
    }

    /**
     * Set the name for the log.
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->attributes['name'] = $name;
    }

    /**
     * Get the value of the log.
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->attributes['value'];
    }

    /**
     * Set the value for the log.
     *
     * @param string $value
     * @return void
     */
    public function setValue(string $value): void
    {
        $this->attributes['value'] = $value;
    }

    /**
     * Get the status of the log.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->attributes['status'];
    }

    /**
     * Set the status for the log.
     *
     * @param string $status
     * @return void
     */
    public function setStatus(string $status): void
    {
        $this->attributes['status'] = $status;
    }
}
