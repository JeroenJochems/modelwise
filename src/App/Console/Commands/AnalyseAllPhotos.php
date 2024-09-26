<?php

namespace App\Console\Commands;

use Domain\Profiles\Actions\AnalysePhoto;
use Domain\Profiles\Models\Photo;
use Illuminate\Console\Command;

class AnalyseAllPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:analyse-all-photos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Analyse all photos in the system.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $photos = Photo::whereNull('analysis')->get();

        $photos->each(function ($photo) {
            app(AnalysePhoto::class)
                ->onQueue()
                ->execute($photo);
        });
    }
}
