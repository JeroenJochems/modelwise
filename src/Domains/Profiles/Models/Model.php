<?php

namespace Domain\Profiles\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\SidemailData\ResetPasswordMailData;
use App\Notifications\SidemailData\Templates;
use Domain\Jobs\Models\Invite;
use Domain\Jobs\Models\RoleView;
use Domain\Profiles\Data\Mail\MailData;
use Domain\Profiles\Enums\Ethnicity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kra8\Snowflake\HasShortflakePrimary;
use Laravel\Sanctum\HasApiTokens;
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
    use HasShortflakePrimary;

    const TAG_TYPE_MODEL_EXPERIENCE = 'Modeling experience';
    const TAG_TYPE_PROFESSIONS = 'Professions';

    const TAG_TYPES = [
        self::TAG_TYPE_MODEL_EXPERIENCE => self::TAG_TYPE_MODEL_EXPERIENCE,
        self::TAG_TYPE_PROFESSIONS => self::TAG_TYPE_PROFESSIONS,
    ];

    protected $guarded = ['password'];

    public function searchableAs(): string
    {
        if (app()->environment('local')) {
            return 'dev_models_index';
        }

        return 'models_index';
    }

    public function role_views() {
        return $this->hasMany(RoleView::class);
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
        'seen_exclusive_countries' => 'boolean',
    ];

    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

    public function getProfilePictureCdnAttribute()
    {
        return $this->profile_picture ? env("CDN_URL").$this->profile_picture : null;
    }

    public function getProfilePictureCdnThumbAttribute()
    {
        return $this->profile_picture ? $this->profile_picture_cdn.'?w=600&h=600&fit=crop&crop=faces&fm=auto' : null;
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

    public function digitals(): MorphMany
    {
        return $this->photos()->where("folder", Photo::FOLDER_DIGITALS);
    }

    public function portfolio(): MorphMany
    {
        return $this->photos()->where("folder", Photo::FOLDER_WORK_EXPERIENCE);
    }

    public function tattoo_photos(): MorphMany
    {
        return $this->photos()->where("folder", Photo::FOLDER_TATTOOS);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(\Domain\Jobs\Models\Application::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
