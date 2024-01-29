<?php

namespace App\Managers;

use App\Models\Chat;
use App\Models\Connection;

class ConnectionManager 
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
        $chat = new Connection();
        
        try {
            $adder_username = $this->userManager->getLoggedUsername();

            $chat->setUsers([$adder_username, $username]);
            $chat->setSender($adder_username);
            $chat->setStatus('pending');

            $chat->save();

        } catch (\Exception $e) {
            $this->errorManager->handleError('error to add contact: '.$e->getMessage(), 500);
        }
    }

    public function getConnectionStatus(string $user_a, string $user_b): ?string
    {
        try {
            $data = Connection::whereJsonContains('users', [$user_a, $user_b])->first();
    
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

    public function getConnectionSender(string $user_a, string $user_b): ?string
    {
        try {
            $data = Connection::whereJsonContains('users', [$user_a, $user_b])->first();
    
            if ($data === null) {
                return null;
            } else {
                return $data->getSender();
            }
        } catch (\Exception $e) {
            $this->errorManager->handleError('Error getting connection sender: ' . $e->getMessage(), 500);
            return null;
        }
    }

    public function getConnections(string $username, string $status): mixed 
    {
        return Connection::whereJsonContains('users', $username)->where('status', $status)->get();
    }

    public function getPendingCount(string $username): int
    {
        $adder_username = $this->userManager->getLoggedUsername();
    
        $count = Connection::whereJsonContains('users', $username)
            ->where(function ($query) use ($adder_username) {
                $query->where('sender', '!=', $adder_username)
                    ->orWhereNull('sender');
            })
            ->where('status', 'pending')
            ->count();
    
        return $count;
    }

    public function updateConnectonStatus(string $username, string $status): void
    {
        $adder_username = $this->userManager->getLoggedUsername();

        if ($this->getConnectionStatus($adder_username, $username) == 'pending') {

            try {
                $connection = Connection::whereJsonContains('users', [$username, $adder_username])->first();
            
                if ($connection) {
                    $connection->status = $status;
                    $connection->save();
                }
            } catch (\Exception $e) {
                $this->errorManager->handleError('error to update status of connection: '.$adder_username.' -> '.$username.': '.$e->getMessage(), 500);
            }
        }
    }
}
