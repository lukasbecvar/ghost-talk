<?php

namespace App\Utils;

use App\Managers\ErrorManager;

class SecurityUtil
{
	private ErrorManager $errorManager;

	public function __construct(ErrorManager $errorManager)
	{
		$this->errorManager = $errorManager;
	}
	
    public function escapeString(string $string): ?string 
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    public function hashValidate(string $plain_text, string $hash): bool 
	{
		return password_verify($plain_text, $hash);
	}

	public function genBcryptHash(string $plain_text, int $cost): string 
	{
		return password_hash($plain_text, PASSWORD_BCRYPT, ['cost' => $cost]);
	}

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
