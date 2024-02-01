<?php

namespace App\Http\Controllers;

use App\Http\Controller;
use App\Managers\UserManager;
use Illuminate\Contracts\View\View;

/**
 * Class AboutController
 *
 * Controller handling requests related to the about page.
 *
 * @package App\Http\Controllers
 */
class AboutController extends Controller
{
    /**
     * The UserManager instance for managing user-related operations.
     *
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * AboutController constructor.
     *
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {  
        $this->userManager = $userManager;
    }

    /**
     * Display the about page.
     *
     * @return View
     */
    public function aboutPage(): View
    {
        // get login data
        $is_loggedin = $this->userManager->isLoggedin();
        $username = $this->userManager->getLoggedUsername();

        return view('components/about', [
            // view state
            'is_loggedin' => $is_loggedin,
            'username' => $username
        ]);
    }
}
