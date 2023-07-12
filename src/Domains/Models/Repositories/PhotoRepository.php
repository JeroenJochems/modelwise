<?php

namespace Domain\Models\Repositories;

use Domain\Models\Models\Model;
use Domain\Models\Models\Photo;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Storage;

class PhotoRepository
{
    /**
     * @param Model|Authenticatable $model
     */
    public function getPhotos(Model $model, string $folder)
    {
        return $model->photos()->where('folder', $folder)->get()
            ->map(function (Photo $photo) {
                return [
                    "id" => $photo->id,
                    "path" => $photo->cdnPath,
                    "deleteRoute" => route('account.photos.delete', $photo),
                ];
            });
    }

    /**
     * @param Model|Authenticatable $model
     */
    public function update(Model $model, string $folder, $photos)
    {
        $newSort = collect($photos)->map(function($photo) use($folder, $model) {
            if (isset($photo['tmpFile'])) {

                if (!isset($photo['deleted']) || $photo['deleted'] == false) {
                    $photoObj = new Photo;
                    $photoObj->model_id = $model->id;
                    $photoObj->path = str_replace("tmp/", "photos/", $photo['tmpFile']);
                    $photoObj->folder = $folder;
                    Storage::copy($photo['tmpFile'], $photoObj->path);
                    $photoObj->save();

                    $photo['id'] = $photoObj->id;
                } else {
                    return null;
                }
            } else {
                if (isset($photo['deleted']) && $photo['deleted'] == true) {
                    $photoObj = Photo::find($photo['id']);
                    Storage::delete($photoObj->path);
                    $photoObj->delete();

                    return null;
                }
            }

            return $photo['id'];
        });


        Photo::setNewOrder($newSort->toArray());
    }
}
