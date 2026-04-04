<?php

namespace App\Http\Controllers\Messanger;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messanger\MessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        // TODO: подгрузка старых сообщений
    }

    public function send(MessageRequest $request)
    {
        $data = $request->validated();
        $data['sender_id'] = auth()->id();
        
        $message = Message::create($data);

        return response()->json(MessageResource::make($message));
    }

    public function delete(Message $message)
    {
        // TODO: удалить сообщение
    }
}
