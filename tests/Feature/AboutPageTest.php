<?php

namespace Tests\Feature;

use Tests\TestCase;

class AboutPageTest extends TestCase
{
    public function test_about(): void
    {
        $response = $this->get('/about');
        $response->assertSee('About Ghost Talk');
        $response->assertSee('Ghost Talk is the lightweight, anonymous chat application');
        $response->assertStatus(200);
    }
}
