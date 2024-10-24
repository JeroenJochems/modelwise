<?php

namespace Tests\Unit\App\Controllers;

use Carbon\Carbon;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Illuminate\Support\Facades\Mail;
use Tests\Work2\Mock\AnalysePhotoMock;
use Tests\Work2\Mock\MovePhotoMock;
use Tests\Work2\Mock\PhashPhotoMock;
use function Pest\Laravel\assertDatabaseHas;

test("it can apply for a role", function () {
    $role = Role::factory()->createOne();
    $model = Model::factory()->createOne();

    MovePhotoMock::setUp();
    PhashPhotoMock::setUp();
    AnalysePhotoMock::setUp();

    Mail::fake();

    $this->be($model)
        ->post(route('applications.store', $role), [
            'role_id' => $role->id,
            'digitals' => [],
            'photos' => [
                ['id' => 1, 'path' => 'tmp/path.jpg', 'isNew' => true, 'mime' => 'image/jpeg'],
                ['id' => 2, 'path' => 'tmp/path2.jpg', 'isNew' => true, 'mime' => 'image/jpeg'],
            ],
            'available_dates' => ['2022-01-01', '2022-01-02'],
        ])
        ->assertRedirect(route('roles.show', $role));

    assertDatabaseHas("listings", [
        'role_id' => $role->id,
        'model_id' => $model->id,
        'applied_at' => Carbon::getTestNow(),
    ]);
});
