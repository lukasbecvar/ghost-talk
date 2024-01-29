<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    public function definition()
    {
        return [
            'users' => [$this->faker->userName, $this->faker->userName],
            'status' => 'active'
        ];
    }
}
