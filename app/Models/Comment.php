<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    } // ENd Of User

    public function video()
    {
        return $this->belongsTo(Video::class);
    } // ENd Of video

    public function replaying()
    {
        return $this->hasMany(Comment::class, 'replay_id', 'id');
    } // End Of replaying


    // Make Last Comment bee First One
    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    } // ENd Of scopeLatestFirst

} // End of Model
