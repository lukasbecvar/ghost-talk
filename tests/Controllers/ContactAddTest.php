<?php

namespace Tests\Controllers;

use Tests\TestCase;
use App\Models\User;

/**
 * Class ContactAddTest
 * 
 * @package Tests\Controllers
 * 
 * The test suite for contact add routes response codes
 */
class ContactAddTest extends TestCase
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
     * Test accessing the 'add contact' page when logged out.
     */
    public function test_add_contact_logout(): void
    {
        $response = $this->get('/contact/add');

        $response->assertSee('You do not have permission to access this page');
        $response->assertStatus(200);
    }
 
    /**
     * Test attempting to add oneself as a contact.
     */
    public function test_add_contact_self_add(): void
    {
        // set session token (simulate auth)
        $_SESSION['user-token'] = 'fVxV91ijRWiMq8NCxpl1LnBSTEt3WUJBTDh6Y1RIYVpMdjZVdW5IcmJOMXh3YmVvYnN2ZjFBRk51eU09';
        
        $response = $this->get('/contact/add?name=(phpunit)-user');

        $response->assertSee("You can't add yourself");
        $response->assertStatus(200);
    }
}