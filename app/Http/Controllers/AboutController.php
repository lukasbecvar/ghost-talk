<?php

namespace App\Http\Controllers;

use App\Http\Controller;

class AboutController extends Controller
{
    public function aboutPage()
    {
        return view('about');
    }
}
