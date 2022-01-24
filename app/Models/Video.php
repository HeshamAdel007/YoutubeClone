<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Video extends Model
{
    use HasFactory;

    protected $table = 'Videos';
    protected $guarded = [];


    public function getRouteKeyName()
    {
        return 'uid';
    } // End Of getRouteKeyName


    public function channel()
    {
        return $this->belongsTo(Channel::class);
    } // End Of channel

    public function getThumbnailAttribute()
    {
        if ($this->thumbnail_image) {
            return '/videos/' . $this->uid . '/' . $this->thumbnail_image;
        } else {
            return '/videos/' . 'default.jpg';
        }
    } // End OF getThumbnailAttribute

    public function getUploadedDateAttribute()
    {
        $d = new Carbon($this->created_at);
        return $d->toFormattedDateString();
    } // End Of getUploadedDateAttribute

    public function likes()
    {
        return $this->hasMany(Like::class);
    } // End Of Like

    public function dislikes()
    {
        return $this->hasMany(Dislike::class);
    } // End Of dislike

    public function doesUserLikedVideo()
    {
        // Chack LikeID == UserId Will Return True Or False
        return $this->likes()->where('user_id', auth()->id())->exists();
    } // End Of doesUserLikedVideo

    public function doesUserDislikeVideo()
    {
        // Chack DislikeID == UserId Will Return True Or False
        return $this->dislikes()->where('user_id', auth()->id())->exists();
    } // End Of doesUserDislikeVideo


    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('replay_id');
    } // End Of Comments


    public function AllCommentsCount()
    {
        return  $this->hasMany(Comment::class)->count();
    } // End Of Comments Count

} // End of Model
