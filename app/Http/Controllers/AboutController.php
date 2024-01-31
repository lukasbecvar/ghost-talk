<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\ChatManager;
use App\Managers\UserManager;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    private UserManager $userManager;

    private ChatManager $chatManager;

    public function __construct(UserManager $userManager, ChatManager $chatManager)
    {  
        $this->userManager = $userManager;
        $this->chatManager = $chatManager;
    }

    public function aboutPage(): View
    {
        // get login data
        $is_loggedin = $this->userManager->isLoggedin();
        $username = $this->userManager->getLoggedUsername();



        
        dd($this->chatManager->getMessages('3'));




        return view('components/about', [
            // view state
            'is_loggedin' => $is_loggedin,
            'username' => $username
        ]);
    }
}
