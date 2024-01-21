<?php

namespace App\Http\Middleware;

use App\Managers\ErrorManager;
use App\Utils\SiteUtil;
use Closure;

class SecurityCheck
{
    private SiteUtil $siteUtil;
    private ErrorManager $errorManager;

    public function __construct(SiteUtil $siteUtil, ErrorManager $errorManager)
    {
        $this->siteUtil = $siteUtil;
        $this->errorManager = $errorManager;
    }

    public function handle($request, Closure $next)
    {
        // check if app not localhost running
        if (!$this->siteUtil->isRunningLocalhost()) {
            if (!$this->siteUtil->isSsl()) {
                $this->errorManager->handleError(500, 'SSL error: connection not running on ssl protocol');
            }
        }

        return $next($request);
    }
}
