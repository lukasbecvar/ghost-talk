<?php

namespace App\Http;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * Class Controller
 *
 * Base controller class for the application.
 *
 * @package App\Http
 */
class Controller extends BaseController
{
    use ValidatesRequests;
}
