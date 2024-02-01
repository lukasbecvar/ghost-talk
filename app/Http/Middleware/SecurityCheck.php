<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\SiteUtil;
use Illuminate\Http\Request;
use App\Managers\ErrorManager;

/**
 * Class SecurityCheck
 *
 * Middleware to perform security checks, such as verifying SSL usage.
 *
 * @package App\Http\Middleware
 */
class SecurityCheck
{
    /**
     * The SiteUtil instance for utility functions.
     *
     * @var SiteUtil
     */
    private SiteUtil $siteUtil;

    /**
     * The ErrorManager instance for handling errors.
     *
     * @var ErrorManager
     */
    private ErrorManager $errorManager;

    /**
     * Create a new middleware instance.
     *
     * @param  SiteUtil      $siteUtil
     * @param  ErrorManager  $errorManager
     */
    public function __construct(SiteUtil $siteUtil, ErrorManager $errorManager)
    {
        $this->siteUtil = $siteUtil;
        $this->errorManager = $errorManager;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // check if app not localhost running
        if (!$this->siteUtil->isRunningLocalhost()) {

            // check if page running over SSL
            if (!$this->siteUtil->isSsl() && $_ENV['ONLY_SSL'] == 'true') {
                $this->errorManager->handleError('SSL error: connection not running on ssl protocol', 500);
            }
        }

        return $next($request);
    }
}
