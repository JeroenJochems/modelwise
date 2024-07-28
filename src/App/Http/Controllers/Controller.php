<?php

namespace App\Http\Controllers;

use Domain\Profiles\Models\Photo;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Support\Actions\PhashPhoto;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    public function test()
    {
        $photos = Photo::whereNull('hash')
            ->limit(10000)
            ->get();

        foreach ($photos as $photo) {

            app(PhashPhoto::class)->onQueue()->execute($photo);
        }
    }
}
