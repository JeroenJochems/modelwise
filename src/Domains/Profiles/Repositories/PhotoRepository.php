<?php

namespace Domain\Profiles\Repositories;

use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
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
                    "path" => $photo->cdnPath."?w=600&h=600&fit=crop&crop=faces",
                    "deleteRoute" => route('account.photos.delete', $photo),
                ];
            });
    }

    public function update(\Illuminate\Database\Eloquent\Model $model, string $folder, $photos)
    {
        $newSort = collect($photos)->map(function($photo) use($folder, $model) {
            if (isset($photo['tmpFile'])) {

                if (!isset($photo['deleted']) || $photo['deleted'] == false) {
                    $photoObj = new Photo;
                    $photoObj->photoable()->associate($model);
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
