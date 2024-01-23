<?php

namespace App\Managers;

use App\Models\User;
use App\Utils\SessionUtil;
use Illuminate\Support\Facades\Hash;

class UserManager 
{
    private SessionUtil $sessionUtil;

    public function __construct(SessionUtil $sessionUtil)
    {
        $this->sessionUtil = $sessionUtil;
    }

    public function getUserToken(string $username): ?string
    {
        $user = new User();

        $user_data = $user->where('username', $username)->first(); 

        return $user_data->getToken();
    }

    public function checkIsTokenExist(string $token): bool
    {
        $user = new User();

        $user_data = $user->where('token', $token)->first(); 

        if ($user_data == null) {
            return false;
        } else {
            return true;
        }
    }

    public function isLogin(): bool
    {
    
        if ($this->sessionUtil->checkSession('user-token')) {
            

            if ($this->checkIsTokenExist($this->sessionUtil->getSessionValue('user-token'))) {

                return true;
            } else {

                $this->sessionUtil->destroySession();

                return false;
            }

        } else {
            return false;
        }
    }

    public function canLogin(string $username, string $password): bool
    {
        $user = new User();

        $user_data = $user->where('username', $username)->first();

        if ($user_data == null) {
            return false;
        } else {

            if (Hash::check($password, $user_data->getPassword())) {

                return true;
            } else {
                return false;
            }
        }
    }

    public function login(string $token): void
    {
        $this->sessionUtil->setSession('user-token', $token);
    }
}
