<?php

namespace App\Models;

use App\Enums\PollStatus;
use App\Events\PollCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Poll extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'join_code',
    ];

    public $translatable = ['title', 'description'];

    protected $casts = [
        'status' => PollStatus::class,
    ];

    public function getRouteKeyName()
    {
        return 'join_code';
    }

    protected static function booted(): void
    {
        static::creating(function ($poll) {
            $poll->join_code = strtoupper(Str::random(8));
        });

        static::created(function ($poll) {
            Log::info('Создан Poll: ' . 'poll_id  => ' . $poll->id);

            broadcast(new PollCreated([
                'id' => $poll->id,
                'title' => $poll->title,
                'description' => $poll->description,
                'join_code' => $poll->join_code,
            ]));
        });
    }

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function options()
    {
        return $this->hasMany(PollOption::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
