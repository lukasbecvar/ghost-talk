<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthenticatorTest extends TestCase
{
    public function test_login_route(): void
    {
        $response = $this->get('/login');
        $response->assertSee('login');
        $response->assertSee('have an account?');
        $response->assertStatus(200);
    }

    public function test_logout(): void
    {
        $response = $this->get('/logout');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }

    public function test_register_route(): void
    {
        $response = $this->get('/register');
        $response->assertSee('registration');
        $response->assertSee('You have an account?');
        $response->assertStatus(200);
    }
}
