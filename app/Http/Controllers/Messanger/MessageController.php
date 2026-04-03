<?php

namespace App\Http\Controllers\Messanger;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        // TODO: подгрузка старых сообщений
    }

    public function store(Request $request)
    {
        // TODO: написать сообщение
    }

    public function delete(Message $message)
    {
        // TODO: удалить сообщение
    }
}
