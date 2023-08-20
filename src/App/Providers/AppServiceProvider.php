<?php

namespace App\Providers;

use Domain\Jobs\Models\Application;
use Domain\Jobs\Models\Brand;
use Domain\Jobs\Models\Job;
use Domain\Jobs\Models\Invite;
use Domain\Jobs\Models\Role;
use Domain\Profiles\Models\Model;
use Domain\Profiles\Models\Photo;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Spatie\Onboard\Facades\Onboard;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Relation::enforceMorphMap([
            'model' => Model::class,
            'job' => Job::class,
            'photo' => Photo::class,
            'role' => Role::class,
            'brand' => Brand::class,
            'application' => Application::class,
            'longlist-model' => Invite::class,
        ]);

        Onboard::addStep('Personal details')
            ->link("onboarding/personal-details")
            ->completeIf(function (Model $model) {
                return !!$model->first_name;
            });


        Onboard::addStep('Profile picture')
            ->link("onboarding/profile-picture")
            ->completeIf(function (Model $model) {
                return !!$model->profile_picture;
            });

        Onboard::addStep('Portfolio')
            ->link("onboarding/portfolio")
            ->completeIf(function (Model $model) {
                return !!$model->photos()->count();
            });

        Onboard::addStep('Socials')
            ->link("onboarding/socials")
            ->completeIf(function (Model $model) {
                return !(is_null($model->instagram) && is_null($model->tiktok));
            });

        Onboard::addStep('Characteristics')
            ->link("onboarding/characteristics")
            ->completeIf(function (Model $model) {
                return $model->height > 0;
            });
    }
}
