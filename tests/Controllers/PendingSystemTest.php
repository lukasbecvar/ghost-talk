<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Models\User;

class PendingSystemTest extends TestCase
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

    public function test_pending_list_guest(): void
    {
        $response = $this->get('/pending/list');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }
 
    public function test_pending_accept_guest(): void
    {
        $response = $this->get('/pending/accept');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    public function test_pending_deny_guest(): void
    {
        $response = $this->get('/pending/deny');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    public function test_pending_list(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';

        $response = $this->get('/pending/list');

        $response->assertSee('Pending contacts');
        $response->assertStatus(200);
    }
}
