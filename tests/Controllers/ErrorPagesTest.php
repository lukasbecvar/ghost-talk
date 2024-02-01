<?php

namespace Tests\Controllers;

use Tests\TestCase;

/**
 * Class ErrorPagesTest
 *
 * @package Tests\Controllers
 *
 * Test suite for error pages to ensure correct HTTP responses and error messages.
 */
class ErrorPagesTest extends TestCase
{
    /**
     * Test for 400 Bad Request error page.
     */
    public function test_error_400(): void
    {
        $response = $this->get('/error/400');
        $response->assertSeeText('Bad request error');
        $response->assertSeeText('Please try to wait and try again later');
        $response->assertStatus(200);
    }

    /**
     * Test for 401 Unauthorized error page.
     */
    public function test_error_401(): void
    {
        $response = $this->get('/error/401');
        $response->assertSeeText('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    /**
     * Test for 403 Forbidden error page.
     */
    public function test_error_403(): void
    {
        $response = $this->get('/error/403');
        $response->assertSeeText('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    /**
     * Test for 404 Not Found error page.
     */
    public function test_error_404(): void
    {
        $response = $this->get('/error/404');
        $response->assertSeeText('Error not found');
        $response->assertSeeText('This page was not found');
        $response->assertStatus(200);
    }

    /**
     * Test for 429 Too Many Requests error page.
     */
    public function test_error_429(): void
    {
        $response = $this->get('/error/429');
        $response->assertSeeText('Too Many Requests error');
        $response->assertSeeText('Please try to wait and try again later');
        $response->assertStatus(200);
    }

    /**
     * Test for 500 Internal Server Error page.
     */
    public function test_error_500(): void
    {
        $response = $this->get('/error/500');
        $response->assertSeeText('Internal Server Error');
        $response->assertSeeText('The server encountered an unexpected condition that prevented it from fulfilling the request');
        $response->assertStatus(200);
    }

    /**
     * Test for custom error page when JavaScript is not enabled.
     */
    public function test_error_unknown(): void
    {
        $response = $this->get('/error/nojs');
        $response->assertSeeText('Please enabled javascript in your browser');
        $response->assertSeeText('Ghost talk require javascript functions only for dynamic update chat');
        $response->assertStatus(200);
    }
    
    /**
     * Test for custom error page when the device is in an unsupported position.
     */
    public function test_error_position(): void
    {
        $response = $this->get('/error/position');
        $response->assertSeeText('Sorry, your device is currently in an unsupported position. To access this feature, please rotate your device to landscape mode or use a device with a wider screen');
        $response->assertStatus(200);
    }

    /**
     * Test for an unknown error page.
     */
    public function test_error_nojs(): void
    {
        $response = $this->get('/error/unknown');
        $response->assertSeeText('Unknown error, please contact the service administrator');
        $response->assertStatus(200);
    }
}
