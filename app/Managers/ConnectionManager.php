<?php

namespace App\Managers;

use App\Models\Connection;

/**
 * Class ConnectionManager
 *
 * Manager class for handling user connections and related functionality.
 *
 * @package App\Managers
 */
class ConnectionManager 
{
    /**
     * The UserManager instance for managing user-related operations.
     *
     * @var UserManager
     */
    private UserManager $userManager;

    /**
     * The ErrorManager instance for handling errors.
     *
     * @var ErrorManager
     */
    private ErrorManager $errorManager;

    /**
     * ConnectionManager constructor.
     *
     * @param UserManager $userManager
     * @param ErrorManager $errorManager
     */
    public function __construct(UserManager $userManager, ErrorManager $errorManager)
    {
        $this->userManager = $userManager;
        $this->errorManager = $errorManager;
    }

    /**
     * Add a new contact.
     *
     * @param string $username
     * @return void
     */
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

    /**
     * Get the connection status between two users.
     *
     * @param string $user_a
     * @param string $user_b
     * @return string|null
     */
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

    /**
     * Get the sender of the connection request.
     *
     * @param string $user_a
     * @param string $user_b
     * @return string|null
     */
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

    /**
     * Get connections for a given user and status.
     *
     * @param string $username
     * @param string $status
     * @return mixed
     */
    public function getConnections(string $username, string $status): mixed 
    {
        return Connection::whereJsonContains('users', $username)->where('status', $status)->get();
    }

    /**
     * Get the count of pending connections for a user.
     *
     * @param string $username
     * @return int
     */
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

    /**
     * Update the status of a connection.
     *
     * @param string $username
     * @param string $status
     * @return void
     */
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

    /**
     * Check if the logged user has access to a given chat.
     *
     * @param string $chat_id
     * @return bool
     */
    public function isChatAccessable(string $chat_id): bool
    {
        $data = Connection::where('id', $chat_id)->first();

        $username = $this->userManager->getLoggedUsername();

        if (in_array($username, $data->users)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the other user in a connection chat.
     *
     * @param string $chat_id
     * @return string|null
     */
    public function getConnectionChatUser(string $chat_id): ?string
    {
        $data = Connection::where('id', $chat_id)->first();
    
        $username = $this->userManager->getLoggedUsername();
    
        $users = $data->getUsers();
    
        $other_user = null;
    
        foreach ($users as $user) {
            if ($user !== $username) {
                $other_user = $user;
                break;
            }
        }
    
        return $other_user;
    }

    /**
     * Get the first chat ID for the logged user.
     *
     * @return string|null
     */
    public function getFirstChatIdForLoggedUser(): ?string
    {
        $username = $this->userManager->getLoggedUsername();

        $connection = Connection::whereJsonContains('users', $username)->first();

        if ($connection != null) {
            if ($connection->getStatus() == 'active') {

                return strval($connection->id);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    /**
     * Delete a connection.
     *
     * @param string $username
     * @return void
     */
    public function deleteConnection(string $username): void
    {
        $logged_user = $this->userManager->getLoggedUsername();

        try {
            $data = Connection::whereJsonContains('users', [$username, $logged_user])->first();
            $data->delete();
        } catch (\Exception $e) {
            $this->errorManager->handleError('error to delete connection: '.$e->getMessage(), 500);
        }
    }
}
