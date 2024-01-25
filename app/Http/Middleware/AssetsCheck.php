<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Managers\ErrorManager;
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
        // get build path (assets folder)
        $build_path = public_path('build');

        // check if assets are builded
        if (!File::exists($build_path)) {
            $this->errorManager->handleError('public/build/ not found, assets is not builded', 500);
        }

        return $next($request);
    }
}
