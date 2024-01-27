<?php

namespace App\Managers;

use App\Models\User;
use App\Utils\SessionUtil;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserManager 
{
    private SessionUtil $sessionUtil;
    private ErrorManager $errorManager;

    public function __construct(SessionUtil $sessionUtil, ErrorManager $errorManager)
    {
        $this->sessionUtil = $sessionUtil;
        $this->errorManager = $errorManager;
    }

    public function register(string $username, string $password): ?string
    {
        // init user entity
        $user = new User();

        // generate password hash
        $password_hash = Hash::make($password);
                
        // generate user token
        $token = Str::random(30);

        // check if the token already exists in the database
        while (User::where('token', $token)->exists()) {
            // regenerate the token if it already exists
            $token = Str::random(30);
        }
                 
        try {
            // set user data
            $user->setUsername($username);
            $user->setPassword($password_hash);
            $user->setToken($token);
            $user->setStatus('active');
            $user->setRole('user');
                     
            // save user data to the database
            $user->save();

            // return state
            return $token;

        } catch(\Exception $e) { 
            $this->errorManager->handleError('Error to insert new user data: '.$e->getMessage(), 500);
            return null;
        }
    }

    public function getUserToken(string $username): ?string
    {
        return $this->getUserData('username', $username)->getToken();
    }

    public function checkIsTokenExist(string $token): bool
    {
        // get user data
        $user_data = $this->getUserData('token', $token);

        // check if user with token exist in database
        if ($user_data == null) {
            return false;
        } else {
            return true;
        }
    }

    public function isLoggedin(): bool
    {
        // check if token is in session
        if ($this->sessionUtil->checkSession('user-token')) {
            
            // check if token exist in database
            if ($this->checkIsTokenExist($this->sessionUtil->getSessionValue('user-token'))) {
                return true;
            } else {
                // destory session with invalid token
                $this->sessionUtil->destroySession();
                
                return false;
            }
        } else {
            return false;
        }
    }

    public function canLogin(string $username, string $password): bool
    {
        // get user data
        $user_data = $this->getUserData('username', $username);

        // check if user exist
        if ($user_data == null) {
            return false;
        } else {
            // check if password is valid
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

    public function getLoggedUsername(): ?string
    {
        // check if user si logged
        if ($this->isLoggedin()) {
            // get user token (from session)
            $token = $this->sessionUtil->getSessionValue('user-token');

            // get user data
            return $this->getUserData('token', $token)->getUsername();
        } else {
            return null;
        }
    }

    public function isUserExist(string $username): bool
    {
        // get user data
        $user_data = $this->getUserData('username', $username);
    
        // check if user exist
        if ($user_data == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @param string $where
     * @param string $value
     * @return \App\Models\User|null
     */
    public function getUserData(string $where, string $value): ?object 
    {
        $user = new User();
        return $user->where($where, $value)->first();
    }
}
