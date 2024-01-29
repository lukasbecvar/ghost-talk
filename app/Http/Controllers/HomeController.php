<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\ConnectionManager;
use App\Managers\UserManager;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    private UserManager $userManager;
    private ConnectionManager $connectionManager;

    public function __construct(UserManager $userManager, ConnectionManager $connectionManager)
    {
        $this->userManager = $userManager;
        $this->connectionManager = $connectionManager;
    }

    public function homePage(): View
    {
        // get login state
        $is_loggedin = $this->userManager->isLoggedin();
        
        // check if user logged in
        if ($is_loggedin == true) {
               
            // get username
            $username = $this->userManager->getLoggedUsername();
            
            // get count of pending connections
            $pending_connections = $this->connectionManager->getPendingCount($username);

            // get connection list
            $connections = $this->connectionManager->getConnections($username, 'active');

            // return main chat box (main component for logged-in users)
            return view('components/main-box', [
                'is_loggedin' => $is_loggedin,
                'username' => $username,

                'pending_connections' => $pending_connections,
                'connections' => $connections
            ]);
        } else {

            // return non main component (for non logged-in users)
            return view('components/home', [
                'is_loggedin' => $is_loggedin
            ]);
        }
    }
}
