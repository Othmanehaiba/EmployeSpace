<?php

namespace App\Models;


// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles; 

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
        'bio',
        'speciallity'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function candidate()
    {
        return $this->hasOne(\App\Models\Candidate::class, 'user_id');
    }

    public function recruteur()
    {
        return $this->hasOne(\App\Models\Recruteur::class, 'user_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendship', 'user_id', 'friend_id')
            ->withTimestamps();
    }
    
    public function friendRequestsSent()
    {
        return $this->hasMany(\App\Models\FriendRequest::class, 'sender_id');
    }
    
    public function friendRequestsReceived()
    {
        return $this->hasMany(\App\Models\FriendRequest::class, 'receiver_id');
    }
}
