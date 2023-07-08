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
        'job_id',
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
                        $longlistedModel->job->client->name,
                        $longlistedModel->job->title,
                        $longlistedModel->job->url || "http://google.nl",
                        $longlistedModel->job->created_at->format('d-m-Y')
                    )
                )
            );
        });
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function model()
    {
        return $this->belongsTo(\Domain\Models\Models\Model::class);
    }
}
