<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\UserManager;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function homePage(): View
    {
        $is_loggedin = $this->userManager->isLoggedin();
        
        if ($is_loggedin) {
            
            $username = $this->userManager->getLoggedUsername();
            
            return view('chat-box', [
                'is_loggedin' => $is_loggedin,
                'username' => $username
            ]);
        } else {
            return view('home', [
                'is_loggedin' => $is_loggedin
            ]);
        }
    }
}
