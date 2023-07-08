<?php

namespace Domain\Models\Models;

use Domain\Jobs\Models\ExclusiveCountry;
use Domain\Jobs\Models\LonglistedModel;
use Domain\Models\Actions\SendMail;
use Domain\Models\Data\Mail\MailData;
use Domain\Models\Data\Mail\ResetPasswordMailData;
use Domain\Models\Data\Templates;
use Domain\Models\Enums\Ethnicity;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class Model extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Searchable;


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

    public function searchableAs(): string
    {
        if (app()->environment('local')) {
            return 'dev_models_index';
        }

        return 'models_index';
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();

        $array['test'] = 'superman';
        return $array;
    }

    public function getScoutKey(): mixed
    {
        return $this->email;
    }

    public function getScoutKeyName(): mixed
    {
        return 'email';
    }

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
        'ethnicity' => Ethnicity::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_subscribed_to_newsletter' => 'boolean',
        'has_completed_onboarding' => 'boolean',
        'is_accepted' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function longlistedJobs()
    {
        return $this->hasMany(LonglistedModel::class);
    }

    public function getProfilePictureCdnAttribute()
    {
        return $this->profile_picture ? env("CDN_URL").$this->profile_picture : null;
    }

    public function getNameAttribute()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function exclusiveCountries()
    {
        return $this->hasMany(ExclusiveCountry::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)
            ->orderBy("folder")
            ->orderBy("sortable_order");
    }

    public function digitals(): HasMany
    {
        return $this->hasMany(Digital::class);
    }

    public function getUserName()
    {
        return $this->first_name." ".$this->last_name;
    }

    public function sendPasswordResetNotification($token)
    {
        app(SendMail::class)(
            new MailData(
                $this,
                Templates::passwordReset,
                new ResetPasswordMailData(
                    reset_password_url: route("password.reset", ['token' => $token])
                ),
            )
        );
    }
}
