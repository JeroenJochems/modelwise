<?php

use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Hire;
use Domain\Jobs\Models\Rejection;

test('it selects only my application', function() {

    $myApplication = Application::factory()->createOne();
    $otherModelAppl = Application::factory()->createOne();

    $applications = Application::query()->open($myApplication->model)->get();

    expect($applications->count())->toBeOne();
});

test('it selects only applications that have no hire', function () {

    $hire = Hire::factory()->createOne();

    $applications = Application::query()->open($hire->application->model)->get();

    expect($applications->count())->toBe(0);
});

test('it selects only applications that have no rejection', function () {

    $rejection = Rejection::factory()->createOne();

    $applications = Application::query()->open($rejection->application->model)->get();

    expect($applications->count())->toBe(0);
});
