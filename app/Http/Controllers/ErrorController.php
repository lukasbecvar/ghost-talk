<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use Illuminate\Contracts\View\View;

class ErrorController extends Controller
{
    public function handleError(string $code): View
    {
        try {
            // handle error view by code
            return view('error/error-'.$code);
        } catch (\Exception) {
            return view('error/error-unknown');
        }
    }
}
