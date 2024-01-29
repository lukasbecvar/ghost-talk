<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\UserManager;
use App\Managers\ErrorManager;
use App\Managers\ConnectionManager;
use App\Utils\SecurityUtil;

class ContactAddController extends Controller
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
        
    public function contactAdd(): mixed
    {
        if ($this->userManager->isLoggedin()) {
            
            $logged_username = $this->userManager->getLoggedUsername();
            
            $username = request('name');
            
            if ($username == null) {
                $this->errorManager->handleError('name get (query string) parameter is null', 400);
            } 

            $username = $this->securityUtil->escapeString($username);

            if ($logged_username == $username) {
                return view('error/error-custom', ['error_msg' => "You can't add yourself"]);
            }

            if (!$this->userManager->isUserExist($username)) {
                $this->errorManager->handleError($username.' not exist in database', 400);
            }
            
            $connection_status = $this->connectionManager->getConnectionStatus($logged_username, $username);

            if ($connection_status == null) {
                $this->connectionManager->addContact($username);
                return redirect('/profile?name='.$username);
            } else {
                return view('error/error-custom', ['error_msg' => 'This connection status is already '.$connection_status]);
            }

        } else {
            return view('error/error-403');
        }
    }
}
