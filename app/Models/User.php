<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Http\Request;
// use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function channel()
    {
        return $this->hasOne(Channel::class);

    } // End Of channel


    public function owns(Video $video)
    {
        return $this->id == $video->channel->user_id;
    } // End Of Owns

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    } // End Of subscriptions

    public function subscribedChannels()
    {
        return $this->belongsToMany(Channel::class, 'subscriptions');
    } // End Of subscribedChannels


    public function isSubscribedTo(Channel $channel)
    {
        // Return True Or False
        return (bool) $this->subscriptions->where('channel_id', $channel->id)->count();
    } // End Of isSubscribedTo


    public function comments()
    {
        return $this->hasMany(Comment::class);
    } // End Of Comment


} // End Of Model
