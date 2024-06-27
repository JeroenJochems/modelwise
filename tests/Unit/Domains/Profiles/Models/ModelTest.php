<?php

namespace Tests\Unit\Domains\Profiles\Models;

use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Tests\TestCase;

class ModelTest extends TestCase
{
    public function test_it_combines_analysis_tags()
    {
        $model = Model::factory()->create();
        $model->photos()->createMany([
            ['analysis' => ['hair' => 'blond, red'], 'path' => 'test', 'folder' => Photo::FOLDER_ACTIVITIES],
            ['analysis' => ['hair' => 'blond, black'], 'path' => 'test', 'folder' => Photo::FOLDER_ACTIVITIES],
        ]);

        $this->assertEquals(['hair' => 'blond, red, black'], $model->toSearchableArray()['photo_values']);
    }
}
