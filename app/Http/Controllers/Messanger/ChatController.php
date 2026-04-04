<?php

namespace App\Http\Controllers\Messanger;

use App\Enums\ChatType;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $chats = Chat::with(['users', 'messages' => function ($query) {
            $query->latest()->limit(1);
        }])
        ->whereHas('users', fn($query) => $query->where('users.id', $userId))
        ->orderByDesc('updated_at')
        ->get();

        return view('messanger.index', compact('chats'));
    }

    public function privateChat(Request $request)
    {
        $authUserId = auth()->id();
        $otherUserId = $request->input('user_id');

        $chat = Chat::where('type', 'private')
            ->whereHas('users', function ($query) use ($authUserId) {
                $query->where('users.id', $authUserId);
            })
            ->whereHas('users', function ($query) use ($otherUserId) {
                $query->where('users.id', $otherUserId);
            })->first();

        if (!$chat) {
            $chat = Chat::create([
               'type' => ChatType::PRIVATE,
            ]);

            $chat->users()->attach([$authUserId, $otherUserId]);
        }

        return redirect()->route('chats.show', $chat->id);
    }

    public function createGroupChat()
    {
        // TODO: создать групповой чат
    }

    public function updateGroupChat()
    {
        // TODO: изменить групповой чат (название, аватар (если будет) и т.д.)
    }

    public function showChat(Chat $chat)
    {
        $this->authorize('view', $chat);
        $chat->load(['users', 'messages' => fn ($query) => $query->latest()->take(50)->orderBy('created_at')]);
        $chat->messages = $chat->messages->reverse()->values();

        return view('messanger.chats.chat', compact('chat'));
    }

    public function deletePrivateChat()
    {
        // TODO: удалить приватный чат
    }

    public function deleteGroupChat()
    {
        // TODO: удалить групповой чат
    }
}
