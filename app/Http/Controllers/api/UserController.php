<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    public function show(string $login)
    {
        $users = User::where('login', 'like', '%' . $login . '%')->paginate(15);

        if($users->first()) {
            return UserResource::collection($users->filter(function (User $value, int $key) {
                return $value->login != auth('api')->user()->login;
            }));
        }

        return response(null, 204);
    }
}
