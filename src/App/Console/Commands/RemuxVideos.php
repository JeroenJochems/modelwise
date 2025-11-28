<?php

namespace App\Console\Commands;

use Domain\Profiles\Actions\VideoToMux;
use Domain\Profiles\Models\Video;
use Illuminate\Console\Command;

class RemuxVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remux-videos';

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
        $videos = Video::where('created_at', '>', '2025-06-05')->get();

        foreach ($videos as $video) {

            app(VideoToMux::class)->onQueue()->execute($video);
            print $video->id.PHP_EOL;
            sleep(1);
            

        }
    }
}
