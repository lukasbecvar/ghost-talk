<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Models\User;

/**
 * Class ContactSearchTest
 * 
 * @package Tests\Controllers
 * 
 * The test suite contact search component
 */
class ContactSearchTest extends TestCase
{
    /**
     * Set up the environment before each test.
     */
    public function setUp(): void
    {
        parent::setUp();

        User::firstOrCreate(
            ['username' => '(phpunit)-user'],
            [
                'password' => bcrypt('testing-password'),
                'token' => 'ujGSyQbkVsRR3xGHAlbwYns3qcRvyF',
                'status' => 'active',
                'role' => 'user'
            ]
        );

        // start session (simulate auth)
        if (session_status() == PHP_SESSION_NONE) {
            if (!headers_sent()) {
                session_start();
            }
        }
    }

    /**
     * Tear down the environment after each test.
     */
    public function tearDown(): void
    {
        // destory testing session
        session_destroy();
        parent::tearDown();
    }

    /**
     * Test accessing the contact search route when not logged in.
     */
    public function test_contact_search_route_non_logged(): void
    {
        $response = $this->get('/contact/search');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }

    /**
     * Test accessing the contact search route when logged in.
     */
    public function test_contact_search_route(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->get('/contact/search');

        $response->assertStatus(200);
    }

    /**
     * Test accessing the contact search route with empty input.
     */
    public function test_contact_search_route_empty_input(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->post('/contact/search', [
            'contact-search-submit' => true
        ]);

        $response->assertSee('you must enter the username');
        $response->assertStatus(200);
    }

    /**
     * Test accessing the contact search route with a non-existent user.
     */
    public function test_contact_search_route_nonexist_user(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->post('/contact/search', [
            'contact-search-submit' => true,
            'username' => 'nonexist-testing-username'
        ]);

        $response->assertSee('is not registred in system, check if your input correct!');
        $response->assertStatus(200);
    }

    /**
     * Test accessing the contact search route with valid input.
     */
    public function test_contact_search_route_valid_post(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->post('/contact/search', [
            'contact-search-submit' => true,
            'username' => '(phpunit)-user'
        ]);

        $response->assertRedirect('/profile?name=(phpunit)-user');
    }
}
