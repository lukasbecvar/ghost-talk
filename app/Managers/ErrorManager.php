<?php

namespace App\Managers;

use App\Utils\SiteUtil;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ErrorManager 
{
    private ViewFactory $view;
    private SiteUtil $siteUtil;
    private LogManager $LogManager;

    public function __construct(ViewFactory $view, SiteUtil $siteUtil, LogManager $LogManager)
    {
        $this->view = $view;
        $this->siteUtil = $siteUtil;
        $this->LogManager = $LogManager;
    }

    public function handleError(string $message, int $code): void 
    {
        // build error response
        $error_json = [
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ];

        // save log to database
        $this->LogManager->saveLog('error', $message);

        // check if devmode is enabled
        if ($this->siteUtil->isDevMode()) {
            // die app & return error json
            die(json_encode($error_json));
        } else {
            // handle error page (for non debug session)
            $this->handleErrorView($code);
        }
    }

    public function handleErrorView(int $code): void
    {
        die($this->view->make('error/error-'.$code)->render());
    }
}
