<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Models\User;

/**
 * Class PendingSystemTest
 *
 * @package Tests\Controllers
 *
 * Test suite for the pending system controller to ensure correct rendering and functionality.
 */
class PendingSystemTest extends TestCase
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
     * Test access to the pending list for a guest user.
     */
    public function test_pending_list_guest(): void
    {
        $response = $this->get('/pending/list');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }
 
    /**
     * Test access to the pending accept page for a guest user.
     */
    public function test_pending_accept_guest(): void
    {
        $response = $this->get('/pending/accept');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    /**
     * Test access to the pending deny page for a guest user.
     */
    public function test_pending_deny_guest(): void
    {
        $response = $this->get('/pending/deny');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    /**
     * Test access to the pending list for an authenticated user.
     */
    public function test_pending_list(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';

        $response = $this->get('/pending/list');

        $response->assertSee('Pending contacts');
        $response->assertStatus(200);
    }
}
