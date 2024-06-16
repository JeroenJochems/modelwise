<?php

namespace Domain\Profiles\Repositories;

use Domain\Profiles\Actions\AnalysePhoto;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Illuminate\Contracts\Auth\Authenticatable;
use Support\Actions\DeletePhoto;
use Support\Actions\MovePhoto;
use Support\Actions\PhashPhoto;

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
                    "path" => $photo->path,
                    "mime" => "image/*",
                    "deleteRoute" => route('account.photos.delete', $photo),
                ];
            });
    }

    public function update(\Illuminate\Database\Eloquent\Model|Authenticatable $model, string $folder, $photos)
    {
        $newSort = collect($photos)->map(function($photo) use($folder, $model) {

            if (!isset($photo['isNew'])) {
                if (isset($photo['deleted']) && $photo['deleted'] != 0) {

                    if ($photoObj = Photo::find($photo['id'])) {
                        app(DeletePhoto::class)->onQueue()->execute($photoObj->path);
                        $photoObj->delete();
                    }

                    return null;
                }

                return $photo['id'];
            }

            if (isset($photo['deleted']) && $photo['deleted']!=0) return null;

            $photoObj = new Photo;
            $photoObj->photoable()->associate($model);
            $photoObj->path = str_replace("tmp/", "photos/", $photo['path']);
            $photoObj->folder = $folder;
            $photoObj->save();

            if ($photo['path'] != $photoObj->path) {
                app(MovePhoto::class)->onQueue()->execute($photo['path'], $photoObj->path);

                if ($folder === Photo::FOLDER_ACTIVITIES || $folder === Photo::FOLDER_WORK_EXPERIENCE) {
                    app(AnalysePhoto::class)->onQueue()->execute($photoObj);
                }
                app(PhashPhoto::class)->onQueue()->execute($photoObj);
            }

            return $photoObj->id;
        });


        Photo::setNewOrder($newSort->toArray());
    }
}
