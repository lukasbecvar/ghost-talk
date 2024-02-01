<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Utils\SecurityUtil;
use App\Managers\UserManager;
use App\Managers\ConnectionManager;
use Illuminate\Contracts\View\View;

class ProfileViewerController extends Controller
{
    private UserManager $userManager;
    private SecurityUtil $securityUtil;
    private ConnectionManager $connectionManager;

    public function __construct(UserManager $userManager, SecurityUtil $securityUtil, ConnectionManager $connectionManager)
    {
        $this->userManager = $userManager;
        $this->securityUtil = $securityUtil;
        $this->connectionManager = $connectionManager;
    }

    public function profileViewer(): View
    {
        // get login state
        $is_loggedin = $this->userManager->isLoggedin();

        // check if user logged in
        if ($is_loggedin == true) {

            // get logged username
            $username = $this->userManager->getLoggedUsername();

            // get profile name from query string
            $profile_name = request('name');

            // check if profiel name is seted
            if ($profile_name == null) {
                return view('error/error-400');
            }

            // escape profile name
            $profile_name = $this->securityUtil->escapeString($profile_name);
                
            // check if user exist in system
            if ($this->userManager->isUserExist($profile_name)) {

                // get user token
                $token = $this->userManager->getUserToken($profile_name);

                // get user data 
                $user_data = $this->userManager->getUserData('token', $token);
                
                // get connection status
                $connection_status = $this->connectionManager->getConnectionStatus($profile_name, $username);

                return view('components/profile-viewer', [
                    'is_loggedin' => $is_loggedin,
                    'username' => $username,
    
                    'user_data' => $user_data,
                    'connection_status' => $connection_status
                ]);

            } else {
                return view('error/error-404');
            }
        } else {
            return view('error/error-403');
        }
    }
} 
