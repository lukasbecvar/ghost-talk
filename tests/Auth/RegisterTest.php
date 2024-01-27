<?php

namespace Tests\Auth;

use Tests\TestCase;
use Illuminate\Support\Str;

class RegisterTest extends TestCase
{
    public function test_register(): void
    {
        $response = $this->get('/register');

        $response->assertSee('registration');
        $response->assertSee('You have an account?');
        $response->assertStatus(200);
    }

    public function test_register_empty_username(): void
    {
        $response = $this->post('/register', [
            'register-submit' => true,
        ]);

        $response->assertSee('registration');
        $response->assertSee('you must enter the username');
        $response->assertStatus(200);
    }

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
