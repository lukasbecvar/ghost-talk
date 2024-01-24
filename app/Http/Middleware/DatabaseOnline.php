<?php

namespace App\Http\Middleware;

use App\Managers\ErrorManager;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\Request;

class DatabaseOnline
{
    private ErrorManager $errorManager;
    private DatabaseManager $db;

    public function __construct(ErrorManager $errorManager, DatabaseManager $db)
    {
        $this->errorManager = $errorManager;
        $this->db = $db;
    }

    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $this->db->connection()->getPdo();

        } catch (\Exception $e) {
            $this->errorManager->handleError(500, 'Database error: '.$e->getMessage());
        }

        return $next($request);
    }
}
