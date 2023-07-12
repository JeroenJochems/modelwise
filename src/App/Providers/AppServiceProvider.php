<?php

namespace App\Providers;

use Domain\Models\Models\Model;
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
