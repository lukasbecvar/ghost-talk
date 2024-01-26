<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChatBoxTest extends TestCase
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

    public function test_chat_box(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
