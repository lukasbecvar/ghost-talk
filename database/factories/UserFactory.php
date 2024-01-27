<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password'),
            'token' => Str::random(30),
            'status' => 'active',
            'status' => 'role'
        ];
    }
}
