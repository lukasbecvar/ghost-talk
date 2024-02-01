<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Utils\SecurityUtil;
use App\Managers\UserManager;
use App\Managers\ErrorManager;
use App\Managers\ConnectionManager;

class ConnectionDeleteController extends Controller
{
    private UserManager $userManager;
    private SecurityUtil $securityUtil;
    private ErrorManager $errorManager;
    private ConnectionManager $connectionManager;

    public function __construct(UserManager $userManager, SecurityUtil $securityUtil, ErrorManager $errorManager, ConnectionManager $connectionManager)
    {
        $this->userManager = $userManager;
        $this->securityUtil = $securityUtil;
        $this->errorManager = $errorManager;
        $this->connectionManager = $connectionManager;
    }

    public function deleteConnection(): mixed
    {
        if ($this->userManager->isLoggedin()) {
            
            // get username from url (query)
            $username = request('name');

            // check if username is seted
            if ($username == null) {
                $this->errorManager->handleError('name (query string parameter) is not defined', 400);
                return view('error/error-400');
            } else {
    
                // escape username
                $username = $this->securityUtil->escapeString($username);

                // get current logged username
                $logged_username = $this->userManager->getLoggedUsername();

                // delete connection
                if ($this->connectionManager->getConnectionStatus($username, $logged_username) == 'active') {
                    $this->connectionManager->deleteConnection($username);
                }

                return redirect('/profile?name='.$username);
            }
        } else {
            return view('error/error-403');
        }
    }
}
