<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\ConnectionManager;
use App\Managers\UserManager;
use App\Utils\SecurityUtil;
use Illuminate\Contracts\View\View;

class PendingContactsController extends Controller
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

    public function pendingPage(): View
    {
        // get login state
        $is_loggedin = $this->userManager->isLoggedin();

        // check if user logged in
        if ($is_loggedin == true) {

            // get logged username
            $username = $this->userManager->getLoggedUsername();
            
            // get pending connections data
            $data = $this->connectionManager->getConnections($username, 'pending');

            return view('components/pending-contacts', [
                'is_loggedin' => $is_loggedin,
                'username' => $username,

                'data' => $data
            ]);
        } else {
            return view('error/error-403');
        }
    }

    public function accept(): mixed
    {
        // get login state
        $is_loggedin = $this->userManager->isLoggedin();

        // check if user logged in
        if ($is_loggedin == true) {

            $logged_username = $this->userManager->getLoggedUsername();
            $username = request('name');

            if ($username != null) {

                $username = $this->securityUtil->escapeString($username);

                // check if not accepting self request
                if ($this->connectionManager->getConnectionSender($username, $logged_username) == $logged_username) {
                    return view('error/error-custom', ['error_msg' => "You can't accept self request"]);
                } else {

                    $this->connectionManager->updateConnectonStatus($username, 'active');

                    if ($this->connectionManager->getPendingCount($logged_username) == 0) {
                        return redirect('/');
                    } else {
                        return redirect('pending/list/');
                    }
                    
                }
                
            } else {
                return view('error/error-400');
            }


        } else {
            return view('error/error-403');
        }
    }

    public function deny(): mixed
    {
        // get login state
        $is_loggedin = $this->userManager->isLoggedin();

        // check if user logged in
        if ($is_loggedin == true) {

            $logged_username = $this->userManager->getLoggedUsername();
            $username = request('name');

            if ($username != null) {

                $username = $this->securityUtil->escapeString($username);

                // check if not deny self request
                if ($this->connectionManager->getConnectionSender($username, $logged_username) == $logged_username) {
                    return view('error/error-custom', ['error_msg' => "You can't deny self request"]);
                } else {

                    $this->connectionManager->updateConnectonStatus($username, 'denied');

                    if ($this->connectionManager->getPendingCount($logged_username) == 0) {
                        return redirect('/');
                    } else {
                        return redirect('pending/list/');
                    }

                }
                
            } else {
                return view('error/error-400');
            }

        } else {
            return view('error/error-403');
        }
    }
}
