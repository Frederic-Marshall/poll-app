<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PollOption extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['text', 'poll_id'];
    protected $table = 'poll_options';

    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'option_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->singleFile()->useDisk('public');
    }

    public static function votesCalculate($poll)
    {
        $total = $poll->votes()->count();

        $options = $poll->options()->withCount('votes')->get()->map(function ($item) use ($total) {
            $votesCount = $item->votes()->count();
            return [
                'id' => $item->id,
                'text' => $item->text,
                'ratio' => $total ? round($votesCount/$total * 100) : 0,
                'image_url' => $item->getFirstMediaUrl('images') ?: null,
            ];
        });

        return $options;
    }
}
