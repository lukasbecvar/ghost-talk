<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * Class VerifyCsrfToken
 *
 * Middleware to verify CSRF tokens on incoming requests.
 *
 * @package App\Http\Middleware
 */
class VerifyCsrfToken extends Middleware
{
    protected $except = [
        // add URIs that should be excluded from CSRF verification
    ];
}
