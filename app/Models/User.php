<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_community_developer',
        'profile_photo',
        'specialization',
        'description',
        'average_rating',
        'instagram_link',
        'github_link',
        'website_link',
        'category_preferences',
    ];

    // Developer Relations
    public function services()
    {
        return $this->hasMany(Service::class, 'id_developer');
    }

    public function assets()
    {
        return $this->hasMany(Asset3D::class, 'id_developer');
    }

    public function projectsAsDeveloper()
    {
        return $this->hasMany(Project::class, 'id_developer');
    }

    public function posts()
    {
        return $this->hasMany(CommunityPost::class, 'id_developer');
    }

    // User Relations
    public function projectsAsClient()
    {
        return $this->hasMany(Project::class, 'id_pengguna');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'id_pengguna'); // Buyer
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    public function assetPurchases()
    {
        return $this->hasMany(AssetPurchase::class, 'id_pengguna');
    }

    public function comments()
    {
        return $this->hasMany(CommunityComment::class, 'id_pengguna');
    }

    public function likes()
    {
        return $this->hasMany(CommunityLike::class, 'id_pengguna');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class, 'id_pengguna'); // Following
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'id_developer'); // Followers
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'id_pengguna');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'id_developer');
    }

    // Helper Methods for User Type Checks
    public function isClient()
    {
        return $this->role === 'client';
    }

    public function isDeveloper()
    {
        return $this->role === 'developer';
    }

    public function isCommunityDeveloper()
    {
        return $this->role === 'developer' && $this->is_community_developer;
    }

    public function canAccessCommunity()
    {
        return $this->isCommunityDeveloper();
    }

    public function canUploadServices()
    {
        return $this->isDeveloper();
    }

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
            'category_preferences' => 'array',
        ];
    }
}
