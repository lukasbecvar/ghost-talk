<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class MaintenanceMode
{
    protected Application $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request, Closure $next): mixed
    {
        if ($this->app->isDownForMaintenance()) {
            return response()->view('error.error-maintenance', [], 503);
        }

        return $next($request);
    }
}
