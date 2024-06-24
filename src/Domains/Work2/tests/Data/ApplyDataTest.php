<?php

namespace Domain\Work2\Tests\Data;

use Domain\Profiles\Models\Model;
use Domain\Work2\Data\ApplyData;
use Domain\Work2\Tests\Mock\AnalysePhotoMock;
use Domain\Work2\Tests\Mock\MovePhotoMock;
use Domain\Work2\Tests\Mock\PhashPhotoMock;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ApplyDataTest extends TestCase
{
    public function test_it_works()
    {
        $model = Model::factory()->createOne();

        Storage::fake();

        MovePhotoMock::setUp();
        AnalysePhotoMock::setUp();
        PhashPhotoMock::setUp();

        $request = [
            'cover_letter' => 'cover letter',
            'brand_conflicted' => 'brand conflicted',
            'digitals' => [
                ['id' => 'id', 'path' => 'tmp/1', 'isNew' => true, 'mime' => 'mime']
            ],
            'photos' => [
                ['id' => 'id', 'path' => 'tmp/2', 'isNew' => true, 'mime' => 'mime']
            ],
            'available_dates' => ['2022-01-01', '2022-01-02'],
        ];

        $applyData = ApplyData::fromRequest($model, $request);

        expect($applyData->cover_letter)->toBe('cover letter')
            ->and($applyData->brand_conflicted)->toBe('brand conflicted')
            ->and($applyData->digitals[0])->toBeInt()
            ->and($applyData->photos[0])->toBeInt()
            ->and($applyData->available_dates)->toBe(['2022-01-01', '2022-01-02']);
    }
}
