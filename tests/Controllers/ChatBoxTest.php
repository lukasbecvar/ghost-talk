<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Models\User;

class ChatBoxTest extends TestCase
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

    public function test_chat_box(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->get('/');
        
        $response->assertSee('Home');
        $response->assertSee('About');
        $response->assertSee('(phpunit)-user');
        $response->assertSee('Logout');
        $response->assertSee('Pending');
        $response->assertSee('Search contacts');
        $response->assertSee('Send');
        $response->assertSee('Type your message');
        $response->assertStatus(200);
    }
}
