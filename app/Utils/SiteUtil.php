<?php

namespace App\Utils;

/**
 * Class SiteUtil
 *
 * Utility class for site-related operations.
 *
 * @package App\Utils
 */
class SiteUtil
{
    /**
     * Check if the application is in development mode.
     *
     * @return bool True if in development mode, false otherwise.
     */
    public function isDevMode(): bool
    {
        if ($_ENV['APP_DEBUG'] == 'true') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the HTTP host, default to '127.0.0.1' if not set.
     *
     * @return string The HTTP host.
     */
    public function getHttpHost(): string
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }

        return '127.0.0.1';
    }

    /**
     * Check if the application is running on localhost.
     *
     * @return bool True if running on localhost, false otherwise.
     */
    public function isRunningLocalhost(): bool 
    {
		$localhost = false;

        // get host url
        $host = $this->getHttpHost();

        // check if host is null
        if ($host != null) {

            // check if running on url localhost
            if (str_starts_with($host, 'localhost')) {
                $localhost = true;
            } 
                
            // check if running on localhost ip
            if (str_starts_with($host, '127.0.0.1')) {
                $localhost = true;
            }
            
            // check if running on private ip
            if (str_starts_with($host, '10.0.0.93')) {
                $localhost = true;
            }
        }

        return $localhost;
    }

    /**
     * Check if the connection is secure (HTTPS).
     *
     * @return bool True if the connection is secure, false otherwise.
     */
    public function isSsl(): bool 
    {
        // check if set https header
        if (isset($_SERVER['HTTPS'])) {

            // https value (1)
            if ($_SERVER['HTTPS'] == 1) {
                return true;

            // check https value (on)
            } elseif ($_SERVER['HTTPS'] == 'on') {
                return true;
            } else {
                return false;   
            }
        } else {
            return false;   
        }
    }
}
