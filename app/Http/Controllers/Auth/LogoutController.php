<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controller;
use App\Managers\ErrorManager;
use App\Managers\UserManager;
use App\Utils\SessionUtil;

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

    public function logout()
    {
        try {
            if ($this->userManager->isLogin()) {
                $this->sessionUtil->destroySession();
            }
        } catch (\Exception $e) {
            $this->errorManager->handleError(500, 'logout error: '.$e->getMessage());
        }

        return redirect('/login');
    }
}
