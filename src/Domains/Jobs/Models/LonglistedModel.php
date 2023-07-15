<?php

namespace Domain\Jobs\Models;

use Domain\Models\Actions\SendMail;
use Domain\Models\Data\Mail\MailData;
use Domain\Models\Data\Mail\ShortlistedMailData;
use Domain\Models\Data\Templates;
use Illuminate\Database\Eloquent\Model;

class LonglistedModel extends Model
{
    protected $fillable = [
        'role_id',
        'model_id',
    ];


    public static function boot()
    {
        parent::boot();

        self::created(function (LonglistedModel $longlistedModel) {

            app(SendMail::class)(
                new MailData(
                    $longlistedModel->model,
                    Templates::shortlisted,
                    new ShortlistedMailData(
                        $longlistedModel->role->job->client->name,
                        $longlistedModel->role->job->title,
                        $longlistedModel->role->job->url || "http://google.nl",
                        $longlistedModel->role->start_date->format('d-m-Y')
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
        return $this->belongsTo(\Domain\Models\Models\Model::class);
    }
}
