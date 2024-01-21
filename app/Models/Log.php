<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value', 'status'];

    public function getName(): string
    {
        return $this->attributes['name'];
    }

    public function setName(string $name)
    {
        $this->attributes['name'] = $name;
    }

    public function getValue(): string
    {
        return $this->attributes['value'];
    }

    public function setValue(string $value)
    {
        $this->attributes['value'] = $value;
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
