<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $table = 'likes';
    protected $guarded = [];
    public $timestamps = false;

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

} // End of Model
