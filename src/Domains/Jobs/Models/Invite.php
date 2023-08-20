<?php

namespace Domain\Jobs\Models;

use Domain\Profiles\Actions\SendMail;
use Domain\Profiles\Data\Mail\MailData;
use Domain\Profiles\Data\Mail\ShortlistedMailData;
use Domain\Profiles\Data\Templates;
use Domain\Profiles\QueryBuilders\InviteQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kra8\Snowflake\HasShortflakePrimary;

class Invite extends Model
{
    use HasShortflakePrimary;
    use HasFactory;

    protected $fillable = [
        'role_id',
        'model_id',
    ];

    public function newEloquentBuilder($query): InviteQueryBuilder
    {
        return new InviteQueryBuilder($query);
    }

    public static function boot()
    {
        parent::boot();

        self::created(function (Invite $invite) {

            app(SendMail::class)(
                new MailData(
                    $invite->model,
                    Templates::shortlisted,
                    new ShortlistedMailData(
                        $invite->role->job->client->name,
                        $invite->role->job->title,
                        $invite->role->job->url || "http://google.nl",
                        $invite->role->start_date->format('d-m-Y')
                    )
                )
            );
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function model()
    {
        return $this->belongsTo(\Domain\Profiles\Models\Model::class);
    }
}
