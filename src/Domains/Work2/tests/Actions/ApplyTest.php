<?php

namespace Domain\tests\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Work2\Actions\Apply;
use Domain\Work2\Data\ApplyData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ApplyTest extends TestCase
{
    public function test_it_can_apply()
    {
        list($role, $model, $applyData) = $this->init();

        $roleModel = DB::table("listings")->where("role_id", $role->id)->where("model_id", $model->id)->first();

        expect(intval($roleModel->role_id))->toBe($role->id)
            ->and(intval($roleModel->model_id))->toBe($model->id)
            ->and($roleModel->applied_at)->not()->toBeNull()
            ->and(json_decode($roleModel->photos))->toBe($applyData->photos)
            ->and(json_decode($roleModel->digitals))->toBe($applyData->digitals)
            ->and($roleModel->cover_letter)->toBe($applyData->cover_letter)
            ->and($roleModel->brand_conflicted)->toBe($applyData->brand_conflicted)
            ->and(json_decode($roleModel->available_dates))->toBe($applyData->available_dates)
            ->and($roleModel->casting_questions)->toBe($applyData->casting_questions);
    }

    public function test_it_writes_application_data_to_model()
    {
        list($role, $model, $applyData) = $this->init();

        $model = Model::find($model->id);
        expect(intval($model->height))->toBe($applyData->height)
            ->and(intval($model->chest))->toBe($applyData->chest)
            ->and(intval($model->waist))->toBe($applyData->waist)
            ->and(intval($model->hips))->toBe($applyData->hips)
            ->and(intval($model->shoe_size))->toBe($applyData->shoe_size)
            ->and($model->clothing_size_top)->toBe($applyData->clothing_size_top);
    }

    public function test_it_sends_email_to_responsible_user()
    {
        list($role, $model, $applyData) = $this->init();

        Mail::assertQueued(CleanMail::class, function($mail) use($model, $role) {
            return $mail->hasTo($role->job->responsible_user->email);
        });
    }

    /**
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function init(): array
    {
        $role = Role::factory()->createOne();
        $model = Model::factory()->createOne();

        Mail::fake();

        $this->be($model);

        $applyData = new ApplyData(
            cover_letter: "I am a great model",
            digitals: ["digital1"],
            photos: ["photo1", "photo2"],
            available_dates: ["2022-01-01", "2022-01-02"],
            brand_conflicted: "No",
            casting_questions: null,
            height: 180,
            chest: 90,
            waist: 70,
            hips: 90,
            shoe_size: 42,
            clothing_size_top: "M"
        );

        app()->make(Apply::class)($model, $role, $applyData);
        return array($role, $model, $applyData);
    }
}
