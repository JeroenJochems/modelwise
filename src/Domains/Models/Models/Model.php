<?php

namespace Domain\Models\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Model extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'gender',
        'date_of_birth',
        'city',
        'country',
        'tiktok',
        'instagram',
        'website',
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
        'password' => 'hashed',
        'is_subscribed_to_newsletter' => 'boolean',
        'has_completed_onboarding' => 'boolean',
        'is_accepted' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function getProfilePictureCdnAttribute()
    {
        return $this->profile_picture ? env("CDN_URL").$this->profile_picture : null;
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function getUserName()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function password(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => Hash::make($value),
        );
    }
}
