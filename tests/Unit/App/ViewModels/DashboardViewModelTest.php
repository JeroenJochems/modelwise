<?php

use App\ViewModels\DashboardViewModel;
use Domain\Jobs\Models\Invite;
use Domain\Work\Models\Application;
use Domain\Work\Models\Hire;
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

    $myInvite = Invite::factory()->createOne();
    $otherInvite = Invite::factory()->createOne();

    $vm = new DashboardViewModel($myInvite->model);

    expect($vm->openInvites->count())
        ->toBe(1)
        ->and($vm->openInvites->first()->id)
        ->toBe($myInvite->role->id);

    Notification::assertSentTo($myInvite->model, \App\Notifications\InviteCreated::class);
});

test('selects my hires', function() {

    $myHire = Hire::factory()->createOne();
    $otherHire = Hire::factory()->createOne();

    $vm = new DashboardViewModel($myHire->application->model);

    expect($vm->hires->count())->toBe(1);
});
