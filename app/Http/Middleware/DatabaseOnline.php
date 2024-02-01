<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\SiteUtil;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager;

/**
 * Class DatabaseOnline
 *
 * Middleware for checking the database connection status.
 *
 * @package App\Http\Middleware
 */
class DatabaseOnline
{
    /**
     * The SiteUtil instance for utility functions.
     *
     * @var SiteUtil
     */
    private SiteUtil $siteUtil;

    /**
     * The DatabaseManager instance for managing database connections.
     *
     * @var DatabaseManager
     */
    private DatabaseManager $databaseManager;

    /**
     * DatabaseOnline constructor.
     *
     * @param SiteUtil        $siteUtil
     * @param DatabaseManager $databaseManager
     */
    public function __construct(SiteUtil $siteUtil, DatabaseManager $databaseManager)
    {
        $this->siteUtil = $siteUtil;
        $this->databaseManager = $databaseManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
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
