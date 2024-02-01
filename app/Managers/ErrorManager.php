<?php

namespace App\Managers;

use App\Utils\SiteUtil;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * Class ErrorManager
 *
 * Manager class for handling errors and error views.
 *
 * @package App\Managers
 */
class ErrorManager 
{
    /**
     * The ViewFactory instance for rendering views.
     *
     * @var ViewFactory
     */
    private ViewFactory $view;

    /**
     * The SiteUtil instance for utility functions.
     *
     * @var SiteUtil
     */
    private SiteUtil $siteUtil;

    /**
     * The log manager instance for save/get logs into the database
     * 
     * @var LogManager
     */
    private LogManager $logManager;

    /**
     * ErrorManager constructor.
     *
     * @param ViewFactory $view
     * @param SiteUtil $siteUtil
     * @param LogManager $logManager
     */
    public function __construct(ViewFactory $view, SiteUtil $siteUtil, LogManager $logManager)
    {
        $this->view = $view;
        $this->siteUtil = $siteUtil;
        $this->logManager = $logManager;
    }

    /**
     * Handle and log an error.
     *
     * @param string $message
     * @param int $code
     * @return void
     */
    public function handleError(string $message, int $code): void 
    {
        // build error response
        $error_json = [
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ];

        // save log to database
        $this->logManager->saveLog('error', $message);

        // check if devmode is enabled
        if ($this->siteUtil->isDevMode()) {
            // die app & return error json
            die(json_encode($error_json));
        } else {
            // handle error page (for non debug session)
            $this->handleErrorView($code);
        }
    }

    /**
     * Render and die with the error view.
     *
     * @param int $code
     * @return void
     */
    public function handleErrorView(int $code): void
    {
        die($this->view->make('error/error-'.$code)->render());
    }
}
