<?php

namespace Tests\Feature;

use Tests\TestCase;

class CustomErrorPagesTest extends TestCase
{
    public function test_error_400(): void
    {
        $response = $this->get('/error/400');
        $response->assertSeeText('Bad request error');
        $response->assertSeeText('Please try to wait and try again later');
        $response->assertStatus(200);
    }

    public function test_error_401(): void
    {
        $response = $this->get('/error/401');
        $response->assertSeeText('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    public function test_error_403(): void
    {
        $response = $this->get('/error/403');
        $response->assertSeeText('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    public function test_error_404(): void
    {
        $response = $this->get('/error/404');
        $response->assertSeeText('Error not found');
        $response->assertSeeText('This page was not found');
        $response->assertStatus(200);
    }

    public function test_error_429(): void
    {
        $response = $this->get('/error/429');
        $response->assertSeeText('Too Many Requests error');
        $response->assertSeeText('Please try to wait and try again later');
        $response->assertStatus(200);
    }

    public function test_error_500(): void
    {
        $response = $this->get('/error/500');
        $response->assertSeeText('Internal Server Error');
        $response->assertSeeText('The server encountered an unexpected condition that prevented it from fulfilling the request');
        $response->assertStatus(200);
    }

    public function test_error_unknown(): void
    {
        $response = $this->get('/error/unknown');
        $response->assertSeeText('Unknown error, please contact the service administrator');
        $response->assertStatus(200);
    }
}
