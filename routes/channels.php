<?php

use App\Broadcasting\ChatChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes(['middleware' => ['broadcast']]);

Broadcast::channel('chat.{id}', ChatChannel::class); 
