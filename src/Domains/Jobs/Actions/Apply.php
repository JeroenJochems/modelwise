<?php

namespace Domain\Jobs\Actions;

use App\Notifications\Admin\ApplicationCreated;
use Domain\Jobs\Data\ApplyData;
use Domain\Jobs\Models\Application;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;

class Apply
{
    public function __invoke(ApplyData $applyData)
    {
        $application = Application::firstOrNew([
            'role_id' => $applyData->role->id,
            'model_id' => $applyData->model->id
        ]);

        $application->cover_letter = "Available dates: (".count($applyData->available_dates).") " . join(", ", $applyData->available_dates)."\n\n".request()->get("cover_letter");
        $application->brand_conflicted = $applyData->brand_conflicted;
        $application->save();

        $applyData->model
            ->invites()
            ->where('role_id', $applyData->role->id)
            ->update(['application_id' => $application->id]);

        if ($applyData->height) $applyData->model->height = $applyData->height;
        if ($applyData->chest) $applyData->model->chest = $applyData->chest;
        if ($applyData->waist) $applyData->model->waist = $applyData->waist;
        if ($applyData->hips) $applyData->model->hips = $applyData->hips;
        if ($applyData->shoe_size) $applyData->model->shoe_size = $applyData->shoe_size;
        $applyData->model->save();

        app(PhotoRepository::class)->update($applyData->model, Photo::FOLDER_DIGITALS, request()->digitals);
        app(PhotoRepository::class)->update($application, Application::PHOTO_FOLDER, request()->photos);

        $admin = $applyData->role->job->responsible_user;

        $admin->notify(new ApplicationCreated($application));

        return $application;
    }
}
