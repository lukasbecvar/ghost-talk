<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use App\Http\Controller;
use App\Managers\ErrorManager;
use App\Managers\UserManager;
use App\Models\User;
use App\Utils\SecurityUtil;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private UserManager $userManager;
    private SecurityUtil $securityUtil;
    private ErrorManager $errorManager;

    public function __construct(UserManager $userManager, SecurityUtil $securityUtil, ErrorManager $errorManager)
    {
        $this->userManager = $userManager;
        $this->securityUtil = $securityUtil;
        $this->errorManager = $errorManager;
    }

    public function register(Request $request): mixed
    {
        $is_loggedin = $this->userManager->isLoggedin();

        if ($is_loggedin) {
            return redirect('/');
        }

        $error_msg = null;

        $username = null;
        $password = null;
        $re_password = null;
        
        if ($request->has('register-submit')) {

            $username = request('username');
            $password = request('password');
            $re_password = request('re-password');
    
            if ($username == null) {
                $error_msg = 'you must enter the username';
            } else if ($password == null) {
                $error_msg = 'you must enter the password';
            } else if ($re_password == null) {
                $error_msg = 'you must enter the password again';
            }
        
            if ($error_msg == null) {

                $username = $this->securityUtil->escapeString($username);
                $password = $this->securityUtil->escapeString($password);
                $re_password = $this->securityUtil->escapeString($re_password);

                $username_length = strlen($username);
                $password_length = strlen($password);

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

                $user = new User();
                $user_data = $user->where('username', $username)->first();
                
                if ($user_data !== null) {
                    $error_msg = 'this username is already used, please use another name';
                }
                
                $password_hash = Hash::make($password);

                $token = Str::random(30);

                // Check if the token already exists in the database
                while (User::where('token', $token)->exists()) {
                    // Regenerate the token if it already exists
                    $token = Str::random(30);
                }


                if ($error_msg == null) {
                    
                    try {
                        $user->setUsername($username);
                        $user->setPassword($password_hash);
                        $user->setToken($token);
                        $user->setStatus('active');
                        
                        $user->save();

                        $this->userManager->login($token);

                        if ($this->userManager->isLoggedin()) {
                            return redirect('/');
                        }

                    } catch(\Exception $e) {
                        $this->errorManager->handleError(500, 'Error to insert new user data: '.$e->getMessage());
                    }
                }
            }
        } 

        return view('auth/register', [
            'error_msg' => $error_msg,

            'username' => $username,
            'password' => $password,
            're_password' => $re_password,

            'is_loggedin' => $is_loggedin
        ]);
    }
}
