<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    protected $primaryKey = 'id_postingan';

    protected $fillable = [
        'id_developer',
        'judul',
        'konten',
        'lampiran_url',
        'code',
        'language',
    ];

    public function developer()
    {
        return $this->belongsTo(User::class, 'id_developer');
    }

    public function comments()
    {
        return $this->hasMany(CommunityComment::class, 'community_post_id')
                    ->whereNull('parent_id')
                    ->latest();
    }

    public function likes()
    {
        return $this->hasMany(CommunityLike::class, 'community_post_id');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }




}
