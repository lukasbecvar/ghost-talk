<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectionFactory extends Factory
{
    public function definition()
    {
        return [
            'users' => [$this->faker->userName, 'lordbecvold'],
            'sender' => 'lordbecvold',
            'status' => 'active'
        ];
    }
}
