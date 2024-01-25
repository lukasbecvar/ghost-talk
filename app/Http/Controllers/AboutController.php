<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\UserManager;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {  
        $this->userManager = $userManager;
    }

    public function aboutPage(): View
    {
        // get login data
        $is_loggedin = $this->userManager->isLoggedin();
        $username = $this->userManager->getLoggedUsername();

        return view('about', [
            // view state
            'is_loggedin' => $is_loggedin,
            'username' => $username
        ]);
    }
}
