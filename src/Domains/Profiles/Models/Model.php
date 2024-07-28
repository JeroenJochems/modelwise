<?php

namespace Domain\Profiles\Models;

use App\EmailLog;
use App\Notifications\ResetPasswordNotification;
use Djokicpn\LaravelEmailAuditLog\Models\EmailAudit;
use Domain\Jobs\Models\Role;
use Domain\Jobs\Models\RoleView;
use Domain\Profiles\Enums\Ethnicity;
use Domain\Profiles\Enums\Gender;
use Domain\Profiles\Enums\ModelClass;
use Domain\Work2\Models\Listing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

/**
 * Domain\Profiles\Models\Model
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 */
class Model extends Authenticatable implements Onboardable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use Searchable;
    use HasTags;
    use GetsOnboarded;
    use HasShortflakePrimary;

    public function canBeImpersonated()
    {
        return true;
    }

    const TAG_TYPE_MODEL_EXPERIENCE = 'Modeling experience';
    const TAG_TYPE_PROFESSIONS = 'Professions';
    const TAG_TYPE_SKILLS = 'Skills';

    const TAG_TYPES = [
        self::TAG_TYPE_MODEL_EXPERIENCE => self::TAG_TYPE_MODEL_EXPERIENCE,
        self::TAG_TYPE_SKILLS => self::TAG_TYPE_SKILLS,
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

    public function setInstagramAttribute($value)
    {
        $value = str_replace("@", "", $value);
        $value = str_replace("https://www.instagram.com/", "", $value);

        $this->attributes['instagram'] = $value;
    }

    public function role_views() {
        return $this->hasMany(RoleView::class);
    }

    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        unset($array['profile_picture']);
        $array['tags'] = $this->tags->pluck('name')->toArray();

        foreach ($this->photos as $photo) {
            if (!$photo->analysis) continue;

            foreach ($photo->analysis as $key => $value) {
                foreach (explode(", ", $value) as $word) {
                    $array['photo_values'][$key][] = $word;
                }
            }
        }

        if (isset($array['photo_values'])) {
            foreach ($array['photo_values'] as $key => $value) {
                $array['photo_values'][$key] = implode(", ", array_unique($value));
            }
        }

        return $array;
    }

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    public function getScoutKeyName(): mixed
    {
        return 'id';
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
        "height" => "float",
        'ethnicity' => Ethnicity::class,
        'gender' => Gender::class,
        'model_class' => ModelClass::class,
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_subscribed_to_newsletter' => 'boolean',
        'has_completed_onboarding' => 'boolean',
        'is_accepted' => 'boolean',
        'date_of_birth' => 'date',
        'seen_exclusive_countries' => 'boolean',
    ];

    public function emailLogs() {
        return $this->hasMany(EmailLog::class, 'to', 'email');
    }

    public function getProfilePictureCdnAttribute()
    {
        return $this->profile_picture ? env("CDN_URL").$this->profile_picture : null;
    }

    public function getProfilePictureCdnThumbAttribute()
    {
        return $this->profile_picture ? env("CDN_URL").$this->profile_picture.'?twic=v1/cover=1:1/resize=600/focus=auto' : null;
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

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)
            ->using(Listing::class);
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
