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
    public function update(\Illuminate\Database\Eloquent\Model $model, string $folder, $photos)
    {
        $newSort = collect($photos)->map(function($photo) use($folder, $model) {

            if (array_key_exists("deleted", $photo) && $photo['deleted']===true) {

                if ($photoObj = Photo::find($photo['id'])) {
                    app(DeletePhoto::class)->onQueue()->execute($photoObj);
                    $photoObj->delete();
                }

                return null;
            }

            if (array_key_exists("isNew", $photo) && $photo['isNew']===true) {

                $newPath = str_replace("tmp/", "photos/", $photo['path']);

                app(MovePhoto::class)->execute($photo['path'], $newPath);

                $photoObj = new Photo;
                $photoObj->photoable()->associate($model);
                $photoObj->path = $newPath;
                $photoObj->folder = $folder;
                $photoObj->save();

                if ($folder === Photo::FOLDER_ACTIVITIES || $folder === Photo::FOLDER_WORK_EXPERIENCE) {
                    app(AnalysePhoto::class)->onQueue()->execute($photoObj);
                }
                app(PhashPhoto::class)->onQueue()->execute($photoObj);

                return $photoObj->id;

            }

            return $photo['id'];
        });


        Photo::setNewOrder($newSort->toArray());
    }

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
}
