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
            'role' => 'user'
        ];
    }

    public function create_test_user(): UserFactory
    {
        return $this->state([
            'username' => 'lordbecvold',
            'password' => bcrypt('testtest'),
            'token' => Str::random(30),
            'status' => 'active',
            'role' => 'owner',
        ]);
    }
}
