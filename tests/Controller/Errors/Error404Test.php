<?php

namespace Tests\Controller\Errors;

use Tests\TestCase;

/**
 * Class Error404Test
 *
 * @package Tests
 */
class Error404Test extends TestCase
{
    /**
     * A basic error route test.
     *
     * @return void
     */
    public function test_error_route_returns_a_successful_response(): void
    {
        $response = $this->get('/error/404');
        $response->assertStatus(200);
    }
}
