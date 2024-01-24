<?php

namespace Tests\Controller;

use Tests\TestCase;

/**
 * Class HomeTest
 *
 * @package Tests\Feature
 */
class HomeTest extends TestCase
{
    /**
     * A basic home route test.
     *
     * @return void
     */
    public function test_the_home_route_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        //$response->assertSee('main route');
        $response->assertStatus(200);
    }
}
