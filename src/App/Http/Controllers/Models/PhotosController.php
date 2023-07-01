<?php

namespace App\Http\Controllers\Models;

use App\Http\Controllers\Controller;
use Domain\Models\Data\ModelPhotoData;
use Domain\Models\Models\Photo;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function sort()
    {
        Photo::setNewOrder(explode("," ,request()->input('sorting')));
        redirect(back());
    }

    public function delete(Photo $photo)
    {
        $photo->delete();
        redirect(back());
    }

    public function store(ModelPhotoData $data)
    {
        $photo = new Photo;
        $photo->model_id = auth()->id();
        $photo->path = str_replace("tmp/", "photos/", $data->path);
        $photo->folder = $data->folder;
        Storage::copy($data->path, $photo->path );

        $photo->save();

        redirect(back());
    }
}
