<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controller;
use App\Utils\SecurityUtil;
use Illuminate\Http\Request;
use App\Managers\UserManager;

class RegisterController extends Controller
{
    private UserManager $userManager;
    private SecurityUtil $securityUtil;

    public function __construct(UserManager $userManager, SecurityUtil $securityUtil)
    {
        $this->userManager = $userManager;
        $this->securityUtil = $securityUtil;
    }

    public function register(Request $request): mixed
    {
        // get user login state
        $is_loggedin = $this->userManager->isLoggedin();

        // redirect to home (if user loggedin)
        if ($is_loggedin == true) {
            return redirect('/');
        }

        // default values (to view return)
        $error_msg = null;
        $username = null;
        $password = null;
        $re_password = null;
        
        // check if register submited
        if ($request->has('register-submit')) {

            // get form datas
            $username = request('username');
            $password = request('password');
            $re_password = request('re-password');
    
            // check if data is entered
            if ($username == null) {
                $error_msg = 'you must enter the username';
            } else if ($password == null) {
                $error_msg = 'you must enter the password';
            } else if ($re_password == null) {
                $error_msg = 'you must enter the password again';
            }
        
            // check if error found
            if ($error_msg == null) {

                // escape form data
                $username = $this->securityUtil->escapeString($username);
                $password = $this->securityUtil->escapeString($password);
                $re_password = $this->securityUtil->escapeString($re_password);

                // get data length
                $username_length = strlen($username);
                $password_length = strlen($password);

                // check minimal & maximal username or password length
                if ($username_length < 3) {
                    $error_msg = 'minimal username length is 3 characters';
                } else if ($username_length > 60) {
                    $error_msg = 'maximal username length is 60 characters';
                } else if ($password_length > 60) {
                    $error_msg = 'maximal password length is 60 characters';
                } else if ($password_length < 8) {
                    $error_msg = 'minimal password length is 8 characters';
                } else if ($password != $re_password) {
                    $error_msg = 'your passwords is not match';
                }

                // check if username is already used
                if ($this->userManager->isUserExist($username)) {
                    $error_msg = 'this username is already used, please use another name';
                }
                
                // check if error message found (if register is allowed)
                if ($error_msg == null) {
                    $token = $this->userManager->register($username, $password);
                
                    // check if register is valid
                    if ($token != null) {

                        // set login state
                        $this->userManager->login($token);

                        // redirect to the main route
                        return redirect('/'); 
                    } else {
                        $error_msg = 'unexpected login error, please try contact your admin on: '.$_ENV['CONTACT_EMAIL'];
                    }
                }
            }
        }

        return view('auth/register', [
            // view state
            'error_msg' => $error_msg,
            'is_loggedin' => $is_loggedin,

            // from data (auto fill values)
            'username' => $username,
            'password' => $password,
            're_password' => $re_password
        ]);
    }
}
