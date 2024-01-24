<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\UserManager;

class AboutController extends Controller
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {  
        $this->userManager = $userManager;
    }

    public function aboutPage()
    {
        $is_loggedin = $this->userManager->isLoggedin();

        return view('about', [
            'is_loggedin' => $is_loggedin
        ]);
    }
}
