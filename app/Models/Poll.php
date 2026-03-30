<?php

namespace App\Models;

use App\Enums\PollStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Poll extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'join_code',
    ];

    protected $casts = [
        'status' => PollStatus::class,
    ];

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

    public function getRouteKeyName()
    {
        return 'join_code';
    }

    protected static function booted()
    {
        static::creating(function ($poll) {
            $poll->join_code = strtoupper(Str::random(8));
        });
    }
}
