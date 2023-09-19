<?php

namespace App\Http\Controllers;

use Domain\Profiles\Data\ModelVideoData;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Models\Video;
use Illuminate\Support\Facades\Storage;

class VideosController extends Controller
{
    public function sort()
    {
        Photo::setNewOrder(explode("," ,request()->input('sorting')));
        redirect(back());
    }

    public function delete(Video $video)
    {
        $video->delete();
        redirect(back());
    }
}
