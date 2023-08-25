<?php

namespace Domain\Jobs\Models;

use App\Notifications\InviteCreated;
use Domain\Jobs\QueryBuilders\InviteQueryBuilder;
use Domain\Profiles\Actions\SendMail;
use Domain\Profiles\Data\Mail\MailData;
use Domain\Profiles\Data\Mail\ShortlistedMailData;
use Domain\Profiles\Data\Templates;
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
            $invite->model->notify(new InviteCreated($invite));
        });
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
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
