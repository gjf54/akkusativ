<?php

namespace App\Broadcasting;

use App\Models\User;

class ChatChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join($user, $id): array|bool
    {
        return true;
        if(!$user) return false;

        return $user->chats->where('id', $id)->first() != null;
    }
}
