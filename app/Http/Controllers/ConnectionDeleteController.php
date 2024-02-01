<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Utils\SecurityUtil;
use App\Managers\UserManager;
use App\Managers\ErrorManager;
use App\Managers\ConnectionManager;

/**
 * Class ConnectionDeleteController
 *
 * Controller handling the deletion of user connections.
 *
 * @package App\Http\Controllers
 */
class ConnectionDeleteController extends Controller
{
    /**
     * The UserManager instance for managing user-related operations.
     *
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * The SecurityUtil instance for handling security-related tasks.
     *
     * @var SecurityUtil
     */
    private SecurityUtil $securityUtil;

    /**
     * The ErrorManager instance for handling errors.
     *
     * @var ErrorManager
     */
    private ErrorManager $errorManager;

    /**
     * The ConnectionManager instance for managing user connections.
     *
     * @var ConnectionManager
     */
    private ConnectionManager $connectionManager;

    /**
     * ConnectionDeleteController constructor.
     *
     * @param UserManager $userManager
     * @param SecurityUtil $securityUtil
     * @param ErrorManager $errorManager
     * @param ConnectionManager $connectionManager
     */
    public function __construct(UserManager $userManager, SecurityUtil $securityUtil, ErrorManager $errorManager, ConnectionManager $connectionManager)
    {
        $this->userManager = $userManager;
        $this->securityUtil = $securityUtil;
        $this->errorManager = $errorManager;
        $this->connectionManager = $connectionManager;
    }

    /**
     * Delete a user connection.
     *
     * @return mixed
     */
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
