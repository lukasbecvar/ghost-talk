<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Models\User;

class ProfileVieweTest extends TestCase
{
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

        // start session (simulate auth)
        if (session_status() == PHP_SESSION_NONE) {
            if (!headers_sent()) {
                session_start();
            }
        }
    }

    public function tearDown(): void
    {
        // destory testing session
        session_destroy();
        parent::tearDown();
    }

    public function test_profile_viewer_route_non_logged(): void
    {
        $response = $this->get('/profile?name=(phpunit)-user');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    public function test_profile_viewer_route(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->get('/profile?name=(phpunit)-user');
        $response->assertSee('(phpunit)-user');
        $response->assertSee('active');
        $response->assertSee('user');

        $response->assertStatus(200);
    }
}
