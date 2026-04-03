<?php

namespace App\Models;

use App\Events\MessageSent;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Message extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $fillable = [
        'chat_id',
        'sender_id',
        'body'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('message_media')->singleFile()->useDisk('public');
    }

    public static function booted(): void
    {
        static::created(function ($m) {
            broadcast(new MessageSent([
                'sender_id' => $m->sender_id,
                'chat_id' => $m->chat_id,
                'body' => $m->body,
                'created_at' => $m->created_at,
            ]));
        });
    }

    // Relations
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
