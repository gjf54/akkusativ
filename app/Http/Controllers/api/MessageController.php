<?php

namespace App\Http\Controllers\api;

use App\Events\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStoreRequest;
use App\Jobs\CreateMessageJob;
use App\Models\Chat;
use App\Services\MessageService;
use Illuminate\Http\Request;


class MessageController extends Controller
{

    public function __construct(
        public MessageService $messageServce,
    )
    {}

   
    public function index()
    {
        //
    }

   
    public function store(MessageStoreRequest $request)
    {
        $this->messageServce->send($request);

        return response(status: 204);
    }

   
    public function show(string $id)
    {
        //
    }

   
    public function update(Request $request, string $id)
    {
        //
    }

   
    public function destroy(string $id)
    {
        //
    }
}
