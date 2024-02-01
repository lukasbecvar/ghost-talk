<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Models\User;

/**
 * Class ProfileViewerTest
 *
 * @package Tests\Controllers
 *
 * Test suite for the profile viewer controller to ensure correct rendering and functionality.
 */
class ProfileVieweTest extends TestCase
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
     * Tear down the test environment.
     */
    public function tearDown(): void
    {
        // destory testing session
        session_destroy();
        parent::tearDown();
    }

    /**
     * Test access to the profile viewer route for a non-logged-in user.
     */
    public function test_profile_viewer_route_non_logged(): void
    {
        $response = $this->get('/profile?name=(phpunit)-user');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    /**
     * Test access to the profile viewer route for an authenticated user.
     */
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
