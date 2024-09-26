<?php

namespace App\Console\Commands;

use Domain\Profiles\Models\Photo;
use Illuminate\Console\Command;

class PhashAllMissing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:phash-all-missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $photos = Photo::query()
            ->whereNull('hash')
            ->whereNotIn('id', [677556452105599])
            ->get();

        $this->withProgressBar($photos, function (Photo $photo) {
            app(\Support\Actions\PhashPhoto::class)->execute($photo, true);
        });
    }
}
