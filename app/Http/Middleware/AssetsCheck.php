<?php

namespace App\Http\Middleware;

use App\Managers\ErrorManager;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AssetsCheck
{
    private ErrorManager $errorManager;

    public function __construct(ErrorManager $errorManager)
    {
        $this->errorManager = $errorManager;
    }

    public function handle(Request $request, Closure $next): mixed
    {
        $buildPath = public_path('build');

        if (!File::exists($buildPath)) {
            $this->errorManager->handleError(500, 'public/build/ not found, assets is not builded');
        }

        return $next($request);
    }
}
