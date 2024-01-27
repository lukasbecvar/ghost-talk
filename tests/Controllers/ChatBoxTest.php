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
    }

    public function test_chat_box(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->get('/');
        $response->assertStatus(200);
        session_destroy();
    }
}
