<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\ConnectionManager;
use App\Managers\ErrorManager;
use App\Managers\UserManager;
use App\Utils\SecurityUtil;

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

    public function deleteConnection()
    {
        if ($this->userManager->isLoggedin()) {
            
            $username = request('name');

            if ($username == null) {
                $this->errorManager->handleError('name (query string parameter) is not defined', 400);
            } else {
    
                $username = $this->securityUtil->escapeString($username);

                $this->connectionManager->deleteConnection($username);

                return redirect('/profile?name='.$username);
            }

        } else {
            return view('error/error-403');
        }

    }
}
