<?php

namespace App\Models;

use App\Enums\ChatType;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'type',
        'title',
    ];

    protected $casts = [
        'type' => ChatType::class,
    ];

    public function lastMessage()
    {
        return $this->hasOne(Message::class, 'chat_id')->latestOfMany();
    }

    // Relations
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
