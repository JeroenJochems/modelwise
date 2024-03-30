<?php

namespace App\Console\Commands;

use Domain\Profiles\Actions\AnalysePhoto;
use Domain\Profiles\Models\Photo;
use Illuminate\Console\Command;

class AnalysePhotoCmd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:analyse-photo-cmd {photo}';

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
        $photo = Photo::find($this->argument('photo'));

        app(AnalysePhoto::class)->execute($photo);
    }
}
