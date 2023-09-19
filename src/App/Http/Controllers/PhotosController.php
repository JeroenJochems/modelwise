<?php

namespace App\Http\Controllers;

use Domain\Profiles\Data\ModelPhotoData;
use Domain\Profiles\Models\Photo;
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
}
