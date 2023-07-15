<?php

namespace Domain\Models\Models;

use Domain\Jobs\Models\ExclusiveCountry;
use Domain\Jobs\Models\LonglistedModel;
use Domain\Models\Actions\SendMail;
use Domain\Models\Data\Mail\MailData;
use Domain\Models\Data\Mail\ResetPasswordMailData;
use Domain\Models\Data\Templates;
use Domain\Models\Enums\Ethnicity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;
use Spatie\Onboard\Concerns\GetsOnboarded;
use Spatie\Onboard\Concerns\Onboardable;
use Spatie\Tags\HasTags;

class Model extends Authenticatable implements Onboardable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Searchable;
    use HasTags;
    use GetsOnboarded;

    protected $guarded = ['password'];

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

        $array['tags'] = $this->tags->pluck('name')->toArray();

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

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'photoable')
            ->orderBy("folder")
            ->orderBy("sortable_order");
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
                    reset_password_url: route("password.reset", ['email' => urlencode($this->email), 'token' => $token])
                ),
            )
        );
    }
}
