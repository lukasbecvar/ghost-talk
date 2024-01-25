<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controller;
use App\Utils\SessionUtil;
use App\Managers\UserManager;
use App\Managers\ErrorManager;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    private UserManager $userManager;
    private SessionUtil $sessionUtil;
    private ErrorManager $errorManager;

    public function __construct(UserManager $userManager, SessionUtil $sessionUtil, ErrorManager $errorManager)
    {
        $this->userManager = $userManager;
        $this->sessionUtil = $sessionUtil;
        $this->errorManager = $errorManager;
    }

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
