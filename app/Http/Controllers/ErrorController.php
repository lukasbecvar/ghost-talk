<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\LogManager;
use Illuminate\Contracts\View\View;

/**
 * Class ErrorController
 *
 * Controller handling errors and displaying error views.
 *
 * @package App\Http\Controllers
 */
class ErrorController extends Controller
{
    /**
     * The log manager instance for save/get logs into the database
     * 
     * @var LogManager
     */
    private LogManager $logManager;

    /**
     * ErrorController constructor.
     *
     * @param LogManager $logManager
     */
    public function __construct(LogManager $logManager)
    {
        $this->logManager = $logManager;
    }

    /**
     * Handle and display an error.
     *
     * @param string $code
     * @return View
     */
    public function handleError(string $code): View
    {
        // log error page handle
        $this->logManager->saveLog('handle error page', 'error: '.$code);
        
        // block show custom error by error route
        if ($code == 'custom') {
            $code = 'unknown';
        }

        try {
            // handle error view by code
            return view('error/error-'.$code);
        } catch (\Exception) {
            return view('error/error-unknown');
        }
    }
}
