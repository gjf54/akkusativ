<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatShowRequest;
use App\Http\Requests\ChatStoreRequest;
use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Models\Chat;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ChatController extends Controller
{

    public function index(Request $request)
    {   
        $chats = $request->user()->chats->sortByDesc('updated_at');

        $data = collect();

        foreach($chats as $c) {
            $last_message = Chat::find($c->id)->messages->sortBy('updated_at')->last();

            $data->push([
                'chat' => $c,
                'last_message' => ($last_message ? new MessageResource($last_message) : ''),
                'users' => UserResource::collection($c->users->filter(function (User $value, int $key) {
                    return $value->login != auth('api')->user()->login;
                })),
            ]);
        }

        return response()->json($data);
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
    public function store(ChatStoreRequest $request)
    {
        $c = $request->validated();

        $chat = Chat::create();

        $user = $request->user();
        $f_user = User::where('login', $request->login)->first();

        $chat->users()->attach($user->id);
        $chat->users()->attach($f_user->id);

        return new ChatResource($chat);

    }

    /**
     * Display the specified resource.
     */
    public function show(ChatShowRequest $request, string $id)
    {
        $chat = Chat::find($id);
        if($chat == null || $request->user()->chats->where('id', $chat->id)->first() == null) return response(null, 403);

        return new ChatResource($chat);
        
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


    public function is_exists(Request $request, $login) {

        $user = $request->user();

        if($user->login == $login) {
            return response('Unreal chat.', 500);
        }

        $f_user = User::where('login', $login)->first();
        
        if($f_user) {
            $chats = $user->chats;
            foreach ($chats as $c) {
                if($c->users->contains('login', $f_user->login)) {
                    return $this->show($request, $c->id);
                }

            }
        } else {
            return response('User is not exists.', 500);
        }

        return response(false, 204);

    }
}
