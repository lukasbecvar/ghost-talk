<?php

namespace App\Utils;

use App\Utils\SecurityUtil;

class SessionUtil
{
    private SecurityUtil $securityUtil;

    public function __construct(SecurityUtil $securityUtil)
    {
        $this->securityUtil = $securityUtil;
    }

    public function startSession(): void 
    {
        if (session_status() == PHP_SESSION_NONE) {
            if (!headers_sent()) {
                session_start();
            }
        }
    }

    public function destroySession() {
        $this->startSession();
        session_destroy();
    }

    public function checkSession(string $session_name): bool {
        $this->startSession();
        return isset($_SESSION[$session_name]);
    }

    public function setSession(string $session_name, string $session_value): void 
    {
        $this->startSession();
        $_SESSION[$session_name] = $this->securityUtil->encryptAes($session_value);
    }

    public function getSessionValue(string $session_name): ?string 
    {
        $this->startSession();
        return $this->securityUtil->decryptAes($_SESSION[$session_name]);
    }
}
