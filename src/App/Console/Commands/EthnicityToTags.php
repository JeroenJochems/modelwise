<?php

namespace App\Console\Commands;

use Domain\Profiles\Models\Model;
use Illuminate\Console\Command;
use Spatie\Tags\Tag;

class EthnicityToTags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:ethnicity-to-tags';

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
        Model::whereNotNull('ethnicity')->chunk(100, function ($models) {
            foreach ($models as $model) {

                $tag = Tag::findOrCreate($model->ethnicity->value, Model::TAG_TYPE_LOOKS);

                $model->syncTagsWithType([$tag], Model::TAG_TYPE_LOOKS);

                $this->info("{$model->id} - {$model->ethnicity->value}");
            }
        });
    }
}
