<?php

namespace App\Http\Middleware;

use App\Managers\ErrorManager;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\DatabaseManager;


class DatabaseOnline
{
    private ErrorManager $errorManager;
    private DatabaseManager $db;

    public function __construct(ErrorManager $errorManager, DatabaseManager $db)
    {
        $this->errorManager = $errorManager;
        $this->db = $db;
    }

    public function handle($request, Closure $next)
    {
        try {
            $this->db->connection()->getPdo();
            return $next($request);

        } catch (\Exception $e) {
            $this->errorManager->handleError(500, 'Database error: '.$e->getMessage());
        }
    }
}
