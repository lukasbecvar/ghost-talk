<?php

namespace App\Utils;

use App\Managers\ErrorManager;

/**
 * Class SecurityUtil
 *
 * Utility class for security-related operations.
 *
 * @package App\Utils
 */
class SecurityUtil
{
    /**
     * The ErrorManager instance for handling errors.
     *
     * @var ErrorManager
     */
	private ErrorManager $errorManager;

    /**
     * SecurityUtil constructor.
     *
     * @param ErrorManager $errorManager
     */
	public function __construct(ErrorManager $errorManager)
	{
		$this->errorManager = $errorManager;
	}

    /**
     * Escape special characters in a string to prevent HTML injection.
     *
     * @param string $string The input string to escape.
     * @return string|null The escaped string or null on error.
     */
    public function escapeString(string $string): ?string 
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    /**
     * Validate a plain text against a bcrypt hash.
     *
     * @param string $plain_text The plain text to validate.
     * @param string $hash The bcrypt hash for comparison.
     * @return bool True if the validation succeeds, false otherwise.
     */
    public function hashValidate(string $plain_text, string $hash): bool 
	{
		return password_verify($plain_text, $hash);
	}

    /**
     * Generate a bcrypt hash for a plain text.
     *
     * @param string $plain_text The plain text to hash.
     * @param int $cost The cost parameter for bcrypt.
     * @return string The generated bcrypt hash.
     */
	public function genBcryptHash(string $plain_text, int $cost): string 
	{
		return password_hash($plain_text, PASSWORD_BCRYPT, ['cost' => $cost]);
	}

    /**
     * Encrypt a string using AES encryption.
     *
     * @param string $plain_text The plain text to encrypt.
     * @param string $method The encryption method (default: AES-128-CBC).
     * @return string The base64-encoded encrypted string.
     */
	public function encryptAes(string $plain_text, string $method = 'AES-128-CBC'): string 
	{	
		$key = $_ENV['APP_KEY'];
	
		// derive a fixed-size key using PBKDF2 with SHA-256
		$derived_key = hash_pbkdf2("sha256", $key, "", 10000, 32);
		
		// generate a random Initialization Vector (IV) for added security
		$iv = openssl_random_pseudo_bytes(16);
	
		// encrypt the plain text using AES encryption with the derived key and IV
		$encrypted_data = openssl_encrypt($plain_text, $method, $derived_key, 0, $iv);
	
		// IV and encrypted data, then base64 encode the result
		$result = $iv.$encrypted_data;
	
		return base64_encode($result);
	}
	
    /**
     * Decrypt an AES-encrypted string.
     *
     * @param string $encrypted_data The base64-encoded encrypted string.
     * @param string $method The encryption method (default: AES-128-CBC).
     * @return string|null The decrypted string or null on error.
     */
	public function decryptAes(string $encrypted_data, string $method = 'AES-128-CBC'): ?string 
	{	  
		$key = $_ENV['APP_KEY'];
	
		// derive a fixed-size key using PBKDF2 with SHA-256
		$derived_key = hash_pbkdf2("sha256", $key, "", 10000, 32);
	
		// decode the base64-encoded encrypted data
		$decoded_data = base64_decode($encrypted_data);
	
		// extract the Initialization Vector (IV) from the decoded data
		$iv = substr($decoded_data, 0, 16);
	
		// extract the encrypted data (remaining bytes) from the decoded data
		$encrypted_data = substr($decoded_data, 16);
	
		// decrypt the data using AES decryption with the derived key and IV
		$decrypted_data = openssl_decrypt($encrypted_data, $method, $derived_key, 0, $iv);
	
		// check if decryption was successful
		if ($decrypted_data === false) {
			$this->errorManager->handleError('AES decryption error: '.$encrypted_data.' not decrypted', 500);
			return null; 
		}
	
		return $decrypted_data;
	}
}
