<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Managers\ErrorManager;
use Illuminate\Support\Facades\File;

/**
 * Class AssetsCheck
 *
 * Middleware for checking the existence of build assets.
 *
 * @package App\Http\Middleware
 */
class AssetsCheck
{
    /**
     * The ErrorManager instance for handling errors.
     *
     * @var ErrorManager
     */
    private ErrorManager $errorManager;

    /**
     * AssetsCheck constructor.
     *
     * @param ErrorManager $errorManager
     */
    public function __construct(ErrorManager $errorManager)
    {
        $this->errorManager = $errorManager;
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
        // get build path (assets folder)
        $build_path = public_path('build');

        // check if assets are builded
        if (!File::exists($build_path)) {
            $this->errorManager->handleError('public/build/ not found, assets is not builded', 500);
        }

        return $next($request);
    }
}
