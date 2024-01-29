<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\LogManager;
use Illuminate\Contracts\View\View;

class ErrorController extends Controller
{
    private LogManager $logManager;

    public function __construct(LogManager $logManager)
    {
        $this->logManager = $logManager;
    }

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
