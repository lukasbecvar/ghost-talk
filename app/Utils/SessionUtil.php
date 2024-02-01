<?php

namespace App\Utils;

use App\Utils\SecurityUtil;

/**
 * Class SessionUtil
 *
 * Utility class for session-related operations.
 *
 * @package App\Utils
 */
class SessionUtil
{
    /**
     * The SecurityUtil instance for handling security-related tasks.
     *
     * @var SecurityUtil
     */
    private SecurityUtil $securityUtil;

    /**
     * SessionUtil constructor.
     *
     * @param SecurityUtil $securityUtil
     */
    public function __construct(SecurityUtil $securityUtil)
    {
        $this->securityUtil = $securityUtil;
    }

    /**
     * Start a session if not already started.
     */
    public function startSession(): void 
    {
        if (session_status() == PHP_SESSION_NONE) {
            if (!headers_sent()) {
                session_start();
            }
        }
    }

    /**
     * Destroy the current session.
     */
    public function destroySession(): void 
    {
        $this->startSession();
        session_destroy();
    }

    /**
     * Check if a session variable exists.
     *
     * @param string $session_name The name of the session variable.
     * @return bool True if the session variable exists, false otherwise.
     */
    public function checkSession(string $session_name): bool 
    {
        $this->startSession();
        return isset($_SESSION[$session_name]);
    }

    /**
     * Set a session variable with an encrypted value.
     *
     * @param string $session_name The name of the session variable.
     * @param string $session_value The value to set in the session (plaintext).
     */
    public function setSession(string $session_name, string $session_value): void 
    {
        $this->startSession();
        $_SESSION[$session_name] = $this->securityUtil->encryptAes($session_value);
    }

    /**
     * Get the decrypted value of a session variable.
     *
     * @param string $session_name The name of the session variable.
     * @return string|null The decrypted value or null if the session variable does not exist.
     */
    public function getSessionValue(string $session_name): ?string 
    {
        $this->startSession();
        return $this->securityUtil->decryptAes($_SESSION[$session_name]);
    }
}
