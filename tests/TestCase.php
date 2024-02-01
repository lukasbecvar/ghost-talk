<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * This is the base test case class for Laravel testing.
 * It extends the Laravel's BaseTestCase and uses the CreatesApplication trait.
 * It serves as the foundation for other test cases in the application.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
