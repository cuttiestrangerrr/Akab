<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityLike extends Model
{
    protected $fillable = [
        'community_post_id',
        'user_id',
    ];

    public function post()
    {
        return $this->belongsTo(CommunityPost::class, 'community_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
