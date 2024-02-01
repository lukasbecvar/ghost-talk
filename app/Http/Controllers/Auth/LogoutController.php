<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controller;
use App\Utils\SessionUtil;
use App\Managers\UserManager;
use App\Managers\ErrorManager;
use Illuminate\Http\RedirectResponse;

/**
 * Class LogoutController
 *
 * Controller handling user logout functionality.
 *
 * @package App\Http\Controllers\Auth
 */
class LogoutController extends Controller
{
    /**
     * The UserManager instance for managing user-related operations.
     *
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * The SessionUtil instance for manage session data
     * 
     * @var SessionUtil
     */
    private SessionUtil $sessionUtil;

    /**
     * The ErrorManager instance for handling errors.
     *
     * @var ErrorManager
     */
    private ErrorManager $errorManager;

    /**
     * LogoutController constructor.
     *
     * @param UserManager $userManager
     * @param SessionUtil $sessionUtil
     * @param ErrorManager $errorManager
     */
    public function __construct(UserManager $userManager, SessionUtil $sessionUtil, ErrorManager $errorManager)
    {
        $this->userManager = $userManager;
        $this->sessionUtil = $sessionUtil;
        $this->errorManager = $errorManager;
    }

    /**
     * Handle user logout.
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        try {
            // logout user (if logged in)
            if ($this->userManager->isLoggedin()) {
                $this->sessionUtil->destroySession();
            }
        } catch (\Exception $e) {
            $this->errorManager->handleError('logout error: '.$e->getMessage(), 500);
        }

        // redirect back to login page
        return redirect('/login');
    }
}
