<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;

/**
 * Trait CreatesApplication
 *
 * This trait is used to create and configure the Laravel application for testing purposes.
 * It is typically included in the base test class.
 */
trait CreatesApplication
{
    /**
     * Create and return the Laravel application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__.'/../bootstrap/app.php';
        $app->make(Kernel::class)->bootstrap();
        return $app;
    }
}
