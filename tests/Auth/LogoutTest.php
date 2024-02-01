<?php

namespace Tests\Auth;

use Tests\TestCase;
use App\Models\User;

/**
 * Class LogoutTest
 * 
 * @package Tests\Auth
 * 
 * The test suite for auth logout component
 */
class LogoutTest extends TestCase
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

        // start session (simulate auth)
        if (session_status() == PHP_SESSION_NONE) {
            if (!headers_sent()) {
                session_start();
            }
        }
    }

    /**
     * Test the logout functionality.
     */
    public function test_logout(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->get('/logout');

        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }
}
