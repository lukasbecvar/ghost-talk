<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class MaintenanceMode
 *
 * Middleware for handling maintenance mode.
 *
 * @package App\Http\Middleware
 */
class MaintenanceMode
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Create a new middleware instance.
     *
     * @param  Application  $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // return maintenance view if page is down
        if ($this->app->isDownForMaintenance()) {
            return response()->view('error.error-maintenance', [], 503);
        }
        return $next($request);
    }
}
