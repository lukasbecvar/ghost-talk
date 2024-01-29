<?php

namespace App\Managers;

use App\Models\Chat;

class ContactManager 
{
    private UserManager $userManager;
    private ErrorManager $errorManager;

    public function __construct(UserManager $userManager, ErrorManager $errorManager)
    {
        $this->userManager = $userManager;
        $this->errorManager = $errorManager;
    }

    public function addContact(string $username): void
    {
        $chat = new Chat();
        
        try {
            $adder_username = $this->userManager->getLoggedUsername();

            $chat->setUsers([$adder_username, $username]);
            $chat->setStatus('pending');

            $chat->save();

        } catch (\Exception $e) {
            $this->errorManager->handleError('error to add contact: '.$e->getMessage(), 500);
        }
    }

    public function getConnectionStatus(string $user_a, string $user_b): ?string
    {
        try {
            $data = Chat::whereJsonContains('users', [$user_a, $user_b])->first();
    
            if ($data === null) {
                return null;
            } else {
                return $data->getStatus();
            }
        } catch (\Exception $e) {
            $this->errorManager->handleError('Error getting connection status: ' . $e->getMessage(), 500);
            return null;
        }
    }
}
