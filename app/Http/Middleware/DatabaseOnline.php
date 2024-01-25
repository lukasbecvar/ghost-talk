<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Managers\ErrorManager;
use Illuminate\Database\DatabaseManager;

class DatabaseOnline
{
    private ErrorManager $errorManager;
    private DatabaseManager $databaseManager;

    public function __construct(ErrorManager $errorManager, DatabaseManager $databaseManager)
    {
        $this->errorManager = $errorManager;
        $this->databaseManager = $databaseManager;
    }

    public function handle(Request $request, Closure $next): mixed
    {
        try {
            // get pdo connection
            $this->databaseManager->connection()->getPdo();
        } catch (\Exception $e) {
            $this->errorManager->handleError('Database error: '.$e->getMessage(), 500);
        }

        return $next($request);
    }
}
