<?php

use App\ViewModels\DashboardViewModel;
use Domain\Jobs\Models\Role;
use Domain\Work2\Models\Listing;

test('it creates nested data', function() {

    $listing = Listing::factory()->createOne();

    $listings = Listing::query()->with(["model", "role.job", "photos", "casting_photos", "casting_videos"])->get();

    $data = \Domain\Jobs\Data\ListingData::collect($listings);
});


test('it selects open invites', function() {

    $listingInvited = Listing::factory()->createOne([
        'invited_at' => now(),
    ]);

    $vm = new DashboardViewModel($listingInvited->model);

    expect($vm  ->listings->count())->toBe(1);
});

test('selects my applications', closure: function() {

    $application = Listing::factory()->createOne([
        'applied_at' => now(),
    ]);

    $otherApplication = Listing::factory()->createOne([
        'invited_at' => now(),
    ]);

    $vm = new DashboardViewModel($application->model);

    expect($vm->listings->count())->toBe(1);
});

test('only does not show old invites', function() {

    $listing = Listing::factory()->createOne([
        'invited_at' => now(),
        'role_id' => Role::factory()->createOne([
            'end_date' => now()->subDay(),
        ])->id,
    ]);

    $vm = new DashboardViewModel($listing->model);

    expect($vm->listings->count())
        ->toBe(0);
});

test('it also shows historic hires', function() {

    $listing = Listing::factory()->createOne([
        'hired_at' => now(),
        'role_id' => Role::factory()->createOne([
            'end_date' => now()->subWeek(),
        ])->id,
    ]);

    $vm = new DashboardViewModel($listing->model);

    expect($vm->listings->count())->toBe(1);
});

test('it shows recently viewed roles', function() {
    $role = Role::factory()->createOne();
    $model = \Domain\Profiles\Models\Model::factory()->createOne();

    $model->role_views()->create([
        'role_id' => $role->id,
    ]);

    $vm = new DashboardViewModel($model);

    expect($vm->recentlyViewedRoles->count())->toBe(1);
});
