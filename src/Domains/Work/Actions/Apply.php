<?php

namespace Domain\Work\Actions;

use Domain\Jobs\Data\ApplyData;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Domain\Work\Models\Application;


class Apply3
{
    public function __invoke(ApplyData $applyData)
    {
        $application = Application::firstOrNew([
            'role_id' => $applyData->role->id,
            'model_id' => $applyData->model->id,
        ]);

        $application->cover_letter = $applyData->cover_letter;
        $application->brand_conflicted = $applyData->brand_conflicted;
        $application->casting_questions = $applyData->casting_questions;
        $application->save();

        app(PhotoRepository::class)->update($application, Application::PHOTO_FOLDER, $applyData->photos);
        app(PhotoRepository::class)->update($applyData->model, Photo::FOLDER_DIGITALS, $applyData->digitals);

        $applyData->model
            ->invites()
            ->where('role_id', $applyData->role->id)
            ->update(['application_id' => $application->id]);

        if ($applyData->height) $applyData->model->height = $applyData->height;
        if ($applyData->chest) $applyData->model->chest = $applyData->chest;
        if ($applyData->waist) $applyData->model->waist = $applyData->waist;
        if ($applyData->hips) $applyData->model->hips = $applyData->hips;
        if ($applyData->shoe_size) $applyData->model->shoe_size = $applyData->shoe_size;
        if ($applyData->clothing_size_top) $applyData->model->clothing_size_top = $applyData->clothing_size_top;
        $applyData->model->save();
    }
}
