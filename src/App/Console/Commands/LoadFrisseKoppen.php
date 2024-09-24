<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spekulatius\PHPScraper\PHPScraper;

class LoadFrisseKoppen extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:load-frisse-koppen';

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
        $web = new PHPScraper;
        $x = $web->go('https://www.frissekoppen.nl/modellen/mathias-p');

        dump($web->images);
    }
}
