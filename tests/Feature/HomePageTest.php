<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_route(): void
    {
        $response = $this->get('/home');
        $response->assertSee('Ghost Talk');
        $response->assertStatus(200);
    }

    public function test_home(): void
    {
        $response = $this->get('/');

        // check navigation
        $response->assertSee('Home');
        $response->assertSee('About');
        $response->assertSee('Login');
        
        // check content
        $response->assertSee('Ghost Talk');
        $response->assertSee('You can login to your account');
        $response->assertSee('here');

        // check response code
        $response->assertStatus(200);
    }
}
