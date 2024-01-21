<?php

namespace App\Http\Controllers;

use App\Http\Controller;

class ErrorController extends Controller
{
    public function handleError(string $code)
    {
        try {
            return view('error/error-'.$code);
        } catch (\Exception) {
            return view('error/error-unknown');
        }
    }
}
