<?php

namespace Domain\Profiles\Repositories;

use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Models\Video;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Storage;

class VideoRepository
{
    /**
     * @param Model|Authenticatable $model
     */
    public function getVideos(Model $model, string $folder)
    {
        return $model->photos()->where('folder', $folder)->get()
            ->map(function (Video $video) {
                return [
                    "id" => $video->id,
                    "muxId" => $video->mux_id,
                    "mime" => "video/*",
                    "deleteRoute" => route('account.videos.delete', $video),
                ];
            });
    }

    public function update(\Illuminate\Database\Eloquent\Model $model, string $folder, $videos)
    {
        $newSort = collect($videos)->map(function($video) use($folder, $model) {
            if (!isset($video['tmpFile'])) {
                return $video['id'];
            }

            if (isset($video['deleted']) && $video['deleted']) {
                return null;
            }

            $videoObj = new Video();
            $videoObj->videoable()->associate($model);
            $videoObj->path = str_replace("tmp/", "videos/", $video['tmpFile']);
            $videoObj->folder = $folder;
            Storage::move($video['tmpFile'], $videoObj->path);
            $videoObj->save();

            return $videoObj->id;
        });



        Photo::setNewOrder($newSort->toArray());
    }
}
