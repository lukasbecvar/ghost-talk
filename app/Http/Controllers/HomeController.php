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
        // get login state
        $is_loggedin = $this->userManager->isLoggedin();
        
        // check if user logged in
        if ($is_loggedin == true) {
               
            // get username
            $username = $this->userManager->getLoggedUsername();
            
            // return main chat box (main component for logged-in users)
            return view('chat-box', [
                'is_loggedin' => $is_loggedin,
                'username' => $username
            ]);
        } else {

            // return non main component (for non logged-in users)
            return view('home', [
                'is_loggedin' => $is_loggedin
            ]);
        }
    }
}
