<?php

namespace Domain\tests\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Actions\Invite;
use EventSauce\Clock\TestClock;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class InviteTest extends TestCase
{
    public function test_it_works()
    {
        $clock = new TestClock();
        $clock->tick();

        [$role, $model] = $this->init();

        $this->assertDatabaseHas('listings', [
            'role_id' => $role->id,
            'model_id' => $model->id,
            'invited_at' => $clock->now()->format('Y-m-d H:i:s')
        ]);

        Mail::assertQueued(CleanMail::class, function ($mail) use ($model) {
            return $mail->hasTo($model->email);
        });
    }

    public function test_it_sends_email_to_model()
    {
        [$_, $model] = $this->init();

        Mail::assertQueued(CleanMail::class, function ($mail) use ($model) {
            return $mail->hasTo($model->email);
        });
    }

    private function init(): array
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        Mail::fake();

        app(Invite::class)->execute($role, $model);
        return [$role, $model];
    }


}
