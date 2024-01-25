<?php

namespace App\Http\Middleware;

use Closure;
use App\Utils\SiteUtil;
use Illuminate\Http\Request;
use App\Managers\ErrorManager;

class SecurityCheck
{
    private SiteUtil $siteUtil;
    private ErrorManager $errorManager;

    public function __construct(SiteUtil $siteUtil, ErrorManager $errorManager)
    {
        $this->siteUtil = $siteUtil;
        $this->errorManager = $errorManager;
    }

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
