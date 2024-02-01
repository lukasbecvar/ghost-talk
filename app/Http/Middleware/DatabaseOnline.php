<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\SiteUtil;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;

class DatabaseOnline
{
    private SiteUtil $siteUtil;
    private DatabaseManager $databaseManager;

    public function __construct(SiteUtil $siteUtil, DatabaseManager $databaseManager)
    {
        $this->siteUtil = $siteUtil;
        $this->databaseManager = $databaseManager;
    }

    public function handle(Request $request, Closure $next): mixed
    {
        try {
            // get pdo connection
            $this->databaseManager->connection()->getPdo();
        } catch (\Exception $e) {
            if ($this->siteUtil->isDevMode()) {
                die('Database error: '.$e->getMessage());
            } else {
                die('Internal server error');
            }
        }

        return $next($request);
    }
}
