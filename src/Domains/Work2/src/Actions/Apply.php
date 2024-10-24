<?php

namespace Domain\Work2\Actions;

use App\Mail\CleanMail;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Domain\Work2\Data\ApplyData;
use Domain\Work2\Models\Listing;
use Illuminate\Support\Facades\Mail;

class Apply
{
    public function execute(Model $model, Role $role, ApplyData $applyData): void
    {
        $listing = Listing::firstOrNew(['role_id' => $role->id, 'model_id' => $model->id]);
        $listing->applied_at = now();
        $listing->available_dates = $applyData->available_dates;
        $listing->cover_letter = $applyData->cover_letter;
        $listing->brand_conflicted = $applyData->brand_conflicted;
        $listing->casting_questions = $applyData->casting_questions;
        $listing->save();


        app(PhotoRepository::class)->update($listing, Listing::FOLDER_PHOTOS, $applyData->photos);
        app(PhotoRepository::class)->update($model, Photo::FOLDER_DIGITALS, $applyData->digitals);

        $model->update(
            array_filter(
                $applyData->only('height', 'chest', 'waist', 'hips', 'shoe_size', 'clothing_size_top')->toArray()
            )
        );

        Mail::to($role->job->responsible_user)
            ->send(new CleanMail(
                'New application for ' . $role->job->title,
                $model->name . ' has applied for the role ' . $role->name . ' for ' . $role->job->title . '.'
            ));
    }
}
