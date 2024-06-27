<?php

namespace Domain\Work2\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Domain\Profiles\Repositories\VideoRepository;
use Domain\Work2\Data\ApplyData;
use Domain\Work2\Models\Listing;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ExtendApplication
{
    /**
     * @param Listing $listing
     * @param array{id: string, path: string, isNew: bool, mime: string, deleted: bool} $photos
     * @param array{id: string, path: string, isNew: bool, mime: string, deleted: bool} $videos
     * @return void
     */
    public function __invoke(Listing $listing, array $photos, array $videos): void
    {
        DB::beginTransaction();

        app()->make(PhotoRepository::class)->update($listing, Listing::FOLDER_CASTING_PHOTOS, $photos);
        app()->make(VideoRepository::class)->update($listing, Listing::FOLDER_CASTING_VIDEOS, $videos);

        $listing->extended_application_at = now();
        $listing->save();

        DB::commit();
    }
}
