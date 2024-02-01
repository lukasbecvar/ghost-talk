<?php

namespace Tests\Auth;

use Tests\TestCase;
use App\Models\User;

/**
 * Class LoginTest
 * 
 * @package Tests\Auth
 * 
 * The test suite for auth login component
 */
class LoginTest extends TestCase
{
    /**
     * Set up the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        User::firstOrCreate(
            ['username' => '(phpunit)-user'],
            [
                'password' => bcrypt('testing-password'),
                'token' => 'ujGSyQbkVsRR3xGHAlbwYns3qcRvyF',
                'status' => 'active',
                'role' => 'user'
            ]
        );
    }

    /**
     * Test if the login page is displayed correctly.
     */
    public function test_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertSee('login');
        $response->assertSee('have an account?');
        $response->assertStatus(200);
    }

    /**
     * Test when attempting to login with an empty username.
     */
    public function test_login_empty_username(): void
    {
        $response = $this->post('/login', [
            'login-submit' => true
        ]);

        $response->assertSee('login');
        $response->assertSee('you must enter the username');
        $response->assertStatus(200);
    }

    /**
     * Test when attempting to login with an empty password.
     */
    public function test_login_empty_password(): void
    {
        $response = $this->post('/login', [
            'login-submit' => true,
            'username' => '(phpunit)-user'
        ]);

        $response->assertSee('login');
        $response->assertSee('you must enter the password');
        $response->assertStatus(200);
    }

    /**
     * Test when attempting to login with incorrect data.
     */
    public function test_login_incorrect_data(): void
    {
        $response = $this->post('/login', [
            'login-submit' => true,
            'username' => '(phpunit)-user',
            'password' => 'incorrect-password'
        ]);

        $response->assertSee('login');
        $response->assertSee('incorrect username or password');
        $response->assertStatus(200);
    }

    /**
     * Test when attempting to login with valid data.
     */
    public function test_login_valid_data(): void
    {
        $response = $this->post('/login', [
            'login-submit' => true,
            'username' => '(phpunit)-user',
            'password' => 'testing-password'
        ]);

        $response->assertRedirect('/');
    }
}
