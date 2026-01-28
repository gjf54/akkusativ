<?php

namespace App\Repositories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;

class MessageRepository extends Repository {
    
    public function __construct(
        public Message $message,
    )
    {
        parent::__construct($this->message);
    }
}