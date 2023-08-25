<?php

namespace Domain\Jobs\Actions;

use App\ViewModels\RoleApplyViewModel;
use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Domain\Profiles\Repositories\PhotoRepository;
use Illuminate\Contracts\Auth\Authenticatable;

class Apply
{
    public function __invoke(Model|Authenticatable $model, Role $role)
    {
        $application = Application::firstOrNew([
            'role_id' => $role->id,
            'model_id' => $model->id
        ]);

        $application->cover_letter = request()->get("cover_letter");
        $application->save();

        $model
            ->invites()
            ->where('role_id', $role->id)
            ->update(['application_id' => $application->id]);

        app(PhotoRepository::class)->update($model, Photo::FOLDER_DIGITALS, request()->digitals);
        app(PhotoRepository::class)->update($application, Application::PHOTO_FOLDER, request()->photos);

        return $application;
    }
}
