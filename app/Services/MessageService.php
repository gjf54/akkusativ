<?php

namespace App\Services;

use App\Http\Requests\MessageStoreRequest;
use App\Jobs\CreateMessageJob;
use App\Repositories\ChatRepository;
use App\Repositories\MessageRepository;

class MessageService extends Service {

    public function __construct(
        public MessageRepository $messageRepository,
        public ChatRepository $chatRepository,
    )
    {}

    public function send(MessageStoreRequest $request) {
        
        $this->chatRepository->update(
            $request->validated()['chat_id'],
            [
                'updated_at' => now(),
            ]
        );

        CreateMessageJob::dispatch($request);
    }
}