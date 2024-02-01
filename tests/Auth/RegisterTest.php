<?php

namespace Tests\Auth;

use Tests\TestCase;
use Illuminate\Support\Str;

/**
 * Class RegisterTest
 * 
 * @package Tests\Auth
 * 
 * The test suite for auth register component
 */
class RegisterTest extends TestCase
{
    /**
     * Test the registration page.
     */
    public function test_register(): void
    {
        $response = $this->get('/register');

        $response->assertSee('registration');
        $response->assertSee('You have an account?');
        $response->assertStatus(200);
    }

    /**
     * Test registration with an empty username.
     */
    public function test_register_empty_username(): void
    {
        $response = $this->post('/register', [
            'register-submit' => true,
        ]);

        $response->assertSee('registration');
        $response->assertSee('you must enter the username');
        $response->assertStatus(200);
    }

    /**
     * Test registration with an empty password.
     */
    public function test_register_empty_password(): void
    {
        $response = $this->post('/register', [
            'register-submit' => true,
            'username' => Str::random(10)
        ]);

        $response->assertSee('registration');
        $response->assertSee('you must enter the password');
        $response->assertStatus(200);
    }

    /**
     * Test registration with an empty repeated password.
     */
    public function test_register_empty_repassword(): void
    {
        $response = $this->post('/register', [
            'register-submit' => true,
            'username' => Str::random(10),
            'password' => 'testing-password'
        ]);

        $response->assertSee('registration');
        $response->assertSee('you must enter the password again');
        $response->assertStatus(200);
    }

    /**
     * Test registration with a short username.
     */
    public function test_register_short_username(): void
    {
        $response = $this->post('/register', [
            'register-submit' => true,
            'username' => 'a',
            'password' => 'b',
            're-password' => 'c'
        ]);

        $response->assertSee('registration');
        $response->assertSee('minimal username length is 3 characters');
        $response->assertStatus(200);
    }

    /**
     * Test registration with a short password.
     */
    public function test_register_short_password(): void
    {
        $response = $this->post('/register', [
            'register-submit' => true,
            'username' => 'aaa',
            'password' => 'b',
            're-password' => 'c'
        ]);

        $response->assertSee('registration');
        $response->assertSee('minimal password length is 8 characters');
        $response->assertStatus(200);
    }

    /**
     * Test registration with non-matching passwords.
     */
    public function test_register_password_match(): void
    {
        $response = $this->post('/register', [
            'register-submit' => true,
            'username' => Str::random(10),
            'password' => 'testing-password',
            're-password' => 'testing-idk'
        ]);

        $response->assertSee('registration');
        $response->assertSee('your passwords is not match');
        $response->assertStatus(200);
    }

    /**
     * Test valid registration.
     */
    public function test_register_valid(): void
    {
        $response = $this->post('/register', [
            'register-submit' => true,
            'username' => '(phpunit)-'.Str::random(10),
            'password' => 'testing-password',
            're-password' => 'testing-password'
        ]);

        $response->assertRedirect('/');
    }
}
