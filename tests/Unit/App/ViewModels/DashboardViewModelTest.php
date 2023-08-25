<?php

use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Hire;
use Domain\Jobs\Models\Invite;
use App\ViewModels\DashboardViewModel;
use function Pest\Laravel\{expectsNotification};
use Illuminate\Support\Facades\Notification;

test('it selects open invites', function() {

    $invite = Invite::factory()->createOne();

    $vm = new DashboardViewModel($invite->model);

    expect($vm->openInvites->count())->toBe(1);
});

test('selects my applications', closure: function() {

    $application = Application::factory()->createOne();
    $otherApplication = Application::factory()->createOne();

    $vm = new DashboardViewModel($application->model);

    expect($vm->openApplications->count())->toBe(1);
});

test('only selects my open invites', function() {

    $otherModelInvite = Invite::factory()->createOne();
    $myInvite = Invite::factory()->createOne();

    $vm = new DashboardViewModel($myInvite->model);

    expect($vm->openInvites->count())
        ->toBe(1)
        ->and($vm->openInvites->first()->id)
        ->toBe($myInvite->id);

    Notification::assertSentTo($myInvite->model, \App\Notifications\InviteCreated::class);
});

test('selects my hires', function() {

    $myHire = Hire::factory()->createOne();
    $otherHire = Hire::factory()->createOne();

    $vm = new DashboardViewModel($myHire->application->model);

    expect($vm->hires->count())->toBe(1);
});
