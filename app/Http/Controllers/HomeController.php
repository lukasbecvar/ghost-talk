<?php

namespace App\Http\Controllers;

use App\Http\Controller;

class HomeController extends Controller
{
    public function homePage()
    {
        return view('home');
    }
}
