<?php

namespace Tests\Controllers;

use Tests\TestCase;

/**
 * Class HomePageTest
 *
 * @package Tests\Controllers
 *
 * Test suite for the home page controller to ensure correct rendering and functionality.
 */
class HomePageTest extends TestCase
{
    /**
     * Test for the /home route.
     */
    public function test_home_route(): void
    {
        $response = $this->get('/home');
        $response->assertSee('Ghost Talk');
        $response->assertStatus(200);
    }

    /**
     * Test for the default home page.
     */
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
