<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controller;
use App\Utils\SecurityUtil;
use Illuminate\Http\Request;
use App\Managers\UserManager;

/**
 * Class LoginController
 *
 * Controller handling user login functionality.
 *
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
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
     * LoginController constructor.
     *
     * @param UserManager $userManager
     * @param SecurityUtil $securityUtil
     */
    public function __construct(UserManager $userManager, SecurityUtil $securityUtil)
    {
        $this->userManager = $userManager;
        $this->securityUtil = $securityUtil;
    }

    /**
     * Handle user login.
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request): mixed
    {
        // get login status
        $is_loggedin = $this->userManager->isLoggedin();

        // redirect to home (if user loggedin)
        if ($is_loggedin == true) {
            return redirect('/'); 
        }

        // default values (to view return)
        $error_msg = null;
        $username = null;
        $password = null;
        
        // check if login form submited
        if ($request->has('login-submit')) {
            
            // get form data
            $username = request('username');
            $password = request('password');

            // check if data is entered
            if ($username == null) {
                $error_msg = 'you must enter the username';
            } else if ($password == null) {
                $error_msg = 'you must enter the password';
            }

            // check if error not found
            if ($error_msg == null) {

                // escape form data
                $username = $this->securityUtil->escapeString($username);
                $password = $this->securityUtil->escapeString($password);

                // check if user entered correct data
                if ($this->userManager->canLogin($username, $password)) {
                    
                    // get user token
                    $token = $this->userManager->getUserToken($username);

                    // set login state
                    $this->userManager->login($token);

                    // redirect to home
                    if ($this->userManager->isLoggedin()) {
                        return redirect('/');
                    }

                } else {
                    $error_msg = 'incorrect username or password';
                }
            }
        }

        return view('auth/login', [
            // view state
            'is_loggedin' => $is_loggedin,
            'error_msg' => $error_msg,

            // from data (auto fill values)
            'username' => $username,
            'password' => $password
        ]);
    }
}
