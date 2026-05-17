<?php

namespace App\Console\Commands;

use Domain\Profiles\Models\Video;
use Illuminate\Console\Command;

class PurgeOrphanedMuxUploads extends Command
{
    protected $signature = 'app:purge-orphaned-mux-uploads {--hours=24}';

    protected $description = 'Delete draft Video rows whose Mux Direct Upload was never claimed by a form submit.';

    public function handle(): int
    {
        $cutoff = now()->subHours((int) $this->option('hours'));

        $count = Video::where('folder', Video::FOLDER_DRAFT)
            ->where('created_at', '<', $cutoff)
            ->delete();

        $this->info("Deleted {$count} orphaned draft video rows older than {$cutoff->toDateTimeString()}.");

        return self::SUCCESS;
    }
}
