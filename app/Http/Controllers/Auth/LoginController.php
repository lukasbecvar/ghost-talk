<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controller;
use App\Managers\UserManager;
use App\Utils\SecurityUtil;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    private UserManager $userManager;
    private SecurityUtil $securityUtil;

    public function __construct(UserManager $userManager, SecurityUtil $securityUtil)
    {
        $this->userManager = $userManager;
        $this->securityUtil = $securityUtil;
    }

    public function login(Request $request)
    {
        $is_loggedin = $this->userManager->isLoggedin();
        
        if ($is_loggedin) {
            return redirect('/');
        }

        $error_msg = null;

        $username = null;
        $password = null;
        
        if ($request->has('login-submit')) {
            
            $username = request('username');
            $password = request('password');

            if ($username == null) {
                $error_msg = 'you must enter the username';
            } else if ($password == null) {
                $error_msg = 'you must enter the password';
            }

            if ($error_msg == null) {

                $username = $this->securityUtil->escapeString($username);
                $password = $this->securityUtil->escapeString($password);

                if ($this->userManager->canLogin($username, $password)) {
                    
                    $token = $this->userManager->getUserToken($username);

                    $this->userManager->login($token);

                    if ($this->userManager->isLoggedin()) {
                        return redirect('/');
                    }

                } else {
                    $error_msg = 'incorrect username or password';
                }
                
            }
        }

        return view('auth/login', [
            'error_msg' => $error_msg,

            'username' => $username,
            'password' => $password,

            'is_loggedin' => $is_loggedin
        ]);
    }
}
