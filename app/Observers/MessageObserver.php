<?php

namespace App\Observers;

use App\Events\MessageSentEvent;
use App\Models\Message;

class MessageObserver
{
    
    public function created(Message $message): void
    {
        broadcast(new MessageSentEvent($message->chat))->toOthers();
    }

    
    public function updated(Message $message): void
    {
        //
    }

    
    public function deleted(Message $message): void
    {
        //
    }

    
    public function restored(Message $message): void
    {
        //
    }

    
    public function forceDeleted(Message $message): void
    {
        //
    }
}
