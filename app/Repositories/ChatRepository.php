<?php

namespace App\Repositories;

use App\Models\Chat;

class ChatRepository extends Repository {
    
    public function __construct(
        public Chat $chat,
    )
    {
        parent::__construct($this->chat);
    }
}