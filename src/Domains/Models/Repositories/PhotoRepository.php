<?php

namespace Domain\Models\Repositories;

use Domain\Models\Models\Model;
use Domain\Models\Models\Photo;

class PhotoRepository
{
    public function getPhotos(Model $model, string $folder)
    {
        return $model->photos()->where('folder', $folder)->get()
            ->map(function (Photo $photo) {
                return [
                    "id" => $photo->id,
                    "path" => $photo->cdnPath,
                    "deleteRoute" => route('model.photos.delete', $photo),
                ];
            });
    }
}
