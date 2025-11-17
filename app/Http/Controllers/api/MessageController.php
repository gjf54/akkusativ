<?php

namespace App\Http\Controllers\api;

use App\Events\MessageSentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStoreRequest;
use App\Jobs\CreateMessageJob;
use App\Models\Chat;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageStoreRequest $request)
    {
        $chat_id = $request->validated()['chat_id'];

        Chat::find($chat_id)->update(['updated_at' => now()]);
        
        CreateMessageJob::dispatch($request);

        return response(null, 202);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
