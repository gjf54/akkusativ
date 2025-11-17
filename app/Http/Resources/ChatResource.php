<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $users = $this->users->filter(function ($value, int $key) {
            return $value->login != auth('api')->user()->login;
        });

        return [
            'id' => $this->id,
            'name' => ($this->name ? $this->names : '@' . $users->first()->login),
            'messages' => MessageResource::collection($this->messages()->paginate(100)),
            'users' => UserResource::collection($users),
        ];
    }
}
