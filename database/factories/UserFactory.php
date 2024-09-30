<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
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

    /**
     * Define a specific state for creating a test user.
     *
     * @return UserFactory
     */
    public function create_test_user(): UserFactory
    {
        return $this->state([
            'username' => 'lukasbecvar',
            'password' => bcrypt('testtest'),
            'token' => Str::random(30),
            'status' => 'active',
            'role' => 'owner',
        ]);
    }
}
