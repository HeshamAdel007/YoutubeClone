<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'Channels';
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';

    } // End Of getRouteKeyName

    public function getPictureAttribute()
    {

        if ($this->image) {
            return '/images/' . $this->image;
        } else {
            return '/images/' . 'channel-default.jpg';
        }
    } // End Of getPictureAttribute

    public function user()
    {
        return $this->belongsTo(User::class);

    } // End Of user

    public function videos()
    {
        return $this->hasMany(Video::class);

    } // End Of videos

    public function videosHome()
    {
        return $this->hasMany(Video::class)->where('visibility','public');

    } // End Of videos


    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    } // End Of subscriptions

    public function subscribers()
    {
        return $this->subscriptions->count();
    } // End Of subscribers


} // End of Model
