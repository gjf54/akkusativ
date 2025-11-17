<?php

namespace App\Jobs;

use App\Events\ChatEvent;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class CreateMessageJob implements ShouldQueue
{
    use Queueable;
    
    private $user_login;
    private $chat_id;
    private $message;


    public function __construct(Request $request) 
    {
        $this->user_login = $request->user_login;
        $this->chat_id = $request->chat_id;
        $this->message = $request->message;
    }


    public function handle(): void
    {
        Message::create([
            'user_login' => $this->user_login,
            'chat_id' => $this->chat_id,
            'message' => Crypt::encrypt($this->message),
        ]);

    }
}
