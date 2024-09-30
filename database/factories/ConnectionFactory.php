<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'users' => [$this->faker->userName, 'lukasbecvar'],
            'sender' => 'lukasbecvar',
            'status' => 'active'
        ];
    }
}
