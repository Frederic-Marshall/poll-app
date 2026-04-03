<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
    //implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

//    public function canAccessPanel(Panel $panel): bool
//    {
//        return $this->can('admin_panel', $panel);
//    }

    public function getRouteKeyName()
    {
        return 'nickname';
    }

    // Relations
    public function polls()
    {
        return $this->hasMany(Poll::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function chats()
    {
        return $this->BelongsToMany(Chat::class, 'chat_user');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
