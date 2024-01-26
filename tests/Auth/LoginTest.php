<?php

namespace Tests\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create([
            'username' => 'testing-user',
            'password' => bcrypt('testing-password'),
            'token' => 'ujGSyQbkVsRR3xGHAlbwYns3qcRvyF',
            'status' => 'active'
        ]);
    }

    public function test_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertSee('login');
        $response->assertSee('have an account?');
        $response->assertStatus(200);
    }

    public function test_login_empty_username(): void
    {
        $response = $this->post('/login', [
            'login-submit' => true
        ]);

        $response->assertSee('login');
        $response->assertSee('you must enter the username');
        $response->assertStatus(200);
    }

    public function test_login_empty_password(): void
    {
        $response = $this->post('/login', [
            'login-submit' => true,
            'username' => 'testing-user'
        ]);

        $response->assertSee('login');
        $response->assertSee('you must enter the password');
        $response->assertStatus(200);
    }

    public function test_login_incorrect_data(): void
    {
        $response = $this->post('/login', [
            'login-submit' => true,
            'username' => 'testing-user',
            'password' => 'incorrect-password'
        ]);

        $response->assertSee('login');
        $response->assertSee('incorrect username or password');
        $response->assertStatus(200);
    }

    public function test_login_valid_data(): void
    {
        $response = $this->post('/login', [
            'login-submit' => true,
            'username' => 'testing-user',
            'password' => 'testing-password'
        ]);

        $response->assertRedirect('/');
    }
}
