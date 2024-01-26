<?php

namespace Tests\Auth;

use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function test_logout(): void
    {
        $response = $this->get('/logout');
        $response->assertRedirect('/login');
        $response->assertStatus(302);
    }
}
