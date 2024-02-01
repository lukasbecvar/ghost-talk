<?php

namespace Tests\Controllers;

use Tests\TestCase;

/**
 * Class AboutPageTest
 * 
 * @package Tests\Controllers
 * 
 * The test suite for auth page content
 */
class AboutPageTest extends TestCase
{
    /**
     * Test the about page content.
     */
    public function test_about(): void
    {
        $response = $this->get('/about');
        $response->assertSee('About Ghost Talk');
        $response->assertSee('Ghost Talk is the lightweight, anonymous chat application');
        $response->assertStatus(200);
    }
}
