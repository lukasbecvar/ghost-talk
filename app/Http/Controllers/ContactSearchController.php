<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Utils\SecurityUtil;
use Illuminate\Http\Request;
use App\Managers\UserManager;

class ContactSearchController extends Controller
{
    private UserManager $userManager;
    private SecurityUtil $securityUtil;

    public function __construct(UserManager $userManager, SecurityUtil $securityUtil)
    {
        $this->userManager = $userManager;
        $this->securityUtil = $securityUtil;
    }

    public function searchContact(Request $request): mixed
    {   
        // get login state
        $is_loggedin = $this->userManager->isLoggedin();

        // check if user logged in
        if ($is_loggedin == true) {

            // get logged username
            $username = $this->userManager->getLoggedUsername();
    
            // default values (to view return)
            $error_msg = null;
            $username_input = null;

            // check if login form submited
            if ($request->has('contact-search-submit')) {
                
                // get form data
                $username_input = request('username');

                // check if data is entered
                if ($username_input == null) {
                    $error_msg = 'you must enter the username';
                }

                // check if error not found
                if ($error_msg == null) {
                    // escape form data
                    $username_input = $this->securityUtil->escapeString($username_input);

                    // check if user found in database
                    if ($this->userManager->isUserExist($username_input)) {
                        return redirect('profile?name='.$username_input);
                    } else {
                        $error_msg = $username_input.' is not registred in system, check if your input correct!';
                    }  
                }
            }

            return view('components/contact-search', [
                'is_loggedin' => $is_loggedin,
                'username' => $username,

                'error_msg' => $error_msg,
                'username_input' => $username_input
            ]);
        } else {
            return view('error/error-403');
        }
    }
}
