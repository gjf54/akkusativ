<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'login' => 'test',
            'password' => '123123',
        ]);

        $user2 = User::factory()->create([
            'name' => 'Test User',
            'login' => 'test1',
            'password' => '123123',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'login' => 'test2',
            'password' => '123123',
        ]);

        $chat = Chat::factory()->create();

        Message::factory(5)->create([
            'user_login' => $user->login,
            'chat_id' => $chat->id,
        ]);

        $user->chats()->attach($chat->id);
        $user2->chats()->attach($chat->id);

    }
}
