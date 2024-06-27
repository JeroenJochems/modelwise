<?php

namespace Domain\tests\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Actions\Reject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RejectTest extends TestCase
{
    public function test_it_works()
    {
        [$role, $model] = $this->init();

        $listing = DB::table('listings')
            ->where('role_id', $role->id)
            ->where('model_id', $model->id)
            ->whereNotNull('rejected_at')
            ->count();

        expect($listing)->toBe(1);
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

        $listing = DB::table('listings')->insert([
            'role_id' => $role->id,
            'model_id' => $model->id,
            'rejected_at' => null,
        ]);

        app(Reject::class)->execute($listing, 'subject', 'content');
        return [$role, $model];
    }
}
